<?php
/**
 * Eurofurence Website Core Component
 * Includes debug(), dirmtime(), dircopy() and is_external() as global functions
 * @author	draconigen@gmail.com
 * @since 	11/2015
 * @version	4.00
 * @license	MIT
 */
class EFWebCore
{
	public object $current;

	private ?object $config;
	private string $path;

	public function __construct(string $configfile)
	{
		// load and parse config
		$this->config = json_decode(file_get_contents($configfile), false);
		if (is_null($this->config)) 
		{
			die("Failed to parse " . $configfile . ", reason: " . json_last_error_msg());
		}

		// clear file stat cache
		clearstatcache();

		// ensure correct path settings format
		$this->config->staticOut->path = trim($this->config->staticOut->path, "/") . "/";
		$this->config->defaults->pagesDirectory = trim($this->config->defaults->pagesDirectory, "/") . "/";

		// determine page property key
		$this->path =
			$_SERVER["REQUEST_URI"] === "/" ?
			$this->config->defaults->rootPage :
			trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
				
		// select page from config
		$this->current = 
			property_exists($this->config->pages, $this->path)?
			$this->config->pages->{$this->path} :
			$this->config->pages->{$this->config->defaults->notFoundPage};

		// construct keywords meta tag content
		$this->current->keywords = 
			trim($this->config->defaults->keywords, ",") . "," . $this->current->keywords;

		// construct robots meta tag content
		if (empty($this->current->robots))
		{
			$this->current->robots = $this->config->defaults->robots;
		}

		// start output caching
		ob_start();
	}
		
	/**
	 * Generate appropriate content for the <base> tag. HTTP/S is prefixed according to how 
	 * the website was accessed.
	 * @since 3.00
	 * @return string content for the href attribute of the <base> tag
	 */
	public function get_base() : string
	{
		$mode = 
			((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 
			'https://' : 'http://';

		return str_replace('index.php', '', $mode . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);	
	}

	/**
	 * Returns menu html as a string.
	 * @since 2.00
	 * @return string menu html
	 */
	public function get_menu() : string
	{
		$categorized_pages = [];

		// sort pages into categories ($categorized_pages)
		foreach ($this->config->pages as $key => $page)
		{
			if ($page->inMenu && $page->accessible)
			{
				// if category is not listed in config.menu.categoryOrder, append to end
				if (!array_key_exists($page->category, $categorized_pages))
				{
					$categorized_pages[$page->category] = [];
				}

				$categorized_pages[$page->category][$key] = $page;
			}
		}

		// generate categories html string
		$categories_html = "";
		foreach ($categorized_pages as $category_title => $pages)
		{
			// insert category title
			$category_html = mb_ereg_replace("\{title\}", $category_title, $this->config->menu->templates->category);
			
			// generate items html string
			$items = "";
			foreach ($pages as $key => $page)
			{
				// determine if page uri is external link (e.g. starts with "http(s)://" or "www.")
				$ext = is_external($page->uri);

				// load item template
				$item = $this->config->menu->templates->item;

				// insert href
				$item = mb_ereg_replace("\{href\}", $ext? $page->uri : $key, $item);

				// insert hrefSuffix
				$item = mb_ereg_replace("\{hrefSuffix\}", $this->config->menu->hrefSuffix, $item);

				// insert ActiveClass, if current == page active
				$item = mb_ereg_replace
				(
					"\{ifActiveClass\}",
					($this->current !== $page? "" : $this->config->menu->ifActiveClass),
					$item
				);

				// isert menuText
				$item = mb_ereg_replace("\{menuText\}", $page->menuText, $item);

				// insert lastModified, if enabled
				if ($this->config->menu->enableLastModified && !$ext)
				{
					$lastModified = mb_ereg_replace
					(
						"\{timestamp\}",
						filemtime($this->config->defaults->pagesDirectory . $page->uri),
						$this->config->menu->templates->lastModified
					);
				
					$item = mb_ereg_replace("\{lastModified\}", $lastModified, $item);
				}
				else
				{
					$item = mb_ereg_replace("\{lastModified\}", "", $item);
				}

				// append item to items html string
				$items .= $item;
			}

			// insert item html string into categories html string 
			$categories_html .= mb_ereg_replace("\{items\}", $items, $category_html);
		}

		// insert categories html string into nav html string and return
		return mb_ereg_replace("\{categories\}", $categories_html, $this->config->menu->templates->nav);
	}
	
	/**
	 * Includes the content of the current page.
	 * @since 1.00
	 */
	public function load_content()
	{
		include($this->config->defaults->pagesDirectory . $this->current->uri);
	}

	/**
	 * If config.staticOut is enabled, write output cache to file under
	 * config.staticOut.path. If $_GET["export"] is set, then 
	 * @since 4.00
	 */
	public function end()
	{
		// if static output is enabled, write static file
		if ($this->config->staticOut->enabled)
		{
			$this->write_static_output();
		}

		// end output buffering and obtain buffer content
		$ob = ob_get_contents();
		ob_end_clean();

		// if GET export is set, trigger mechanic to auto-visit every accessible page
		if (isset($_GET['export']))
		{
			// init session handler
			session_start();

			// init session-based autoexport control
			if (!isset($_SESSION["EFWebCoreAutoExport"]))
			{
				$_SESSION["EFWebCoreAutoExport"]["order"] = []; //array_keys(get_object_vars($this->config->pages));
				$_SESSION["EFWebCoreAutoExport"]["total"] = 0;
				$_SESSION["EFWebCoreAutoExport"]["next"] = 0;

				foreach ($this->config->pages as $key => $page)
				{
					if (!is_external($page->uri))
					{
						$_SESSION["EFWebCoreAutoExport"]["order"][] = $key;
						$_SESSION["EFWebCoreAutoExport"]["total"]++;
					}
				}
			}

			$ob = 
				"<h1 id=\"EFWebCoreAutoExport\">EFWebCoreAutoExport: " .
				round($_SESSION["EFWebCoreAutoExport"]["next"] / $_SESSION["EFWebCoreAutoExport"]["total"] * 100) .
				"%</h1>" .
				$ob;

			// set header to load next page in line
			if ($_SESSION["EFWebCoreAutoExport"]["next"] < $_SESSION["EFWebCoreAutoExport"]["total"])
			{
				header
				(
					"Refresh: 1, url=" .
					$this->get_base() .
					$_SESSION["EFWebCoreAutoExport"]["order"][$_SESSION["EFWebCoreAutoExport"]["next"]++] . 
					"?export"
				);
			}
			else 
			{
				session_destroy();
			}
		}

		// finally, send buffer
		echo $ob;
	}

	/**
	 * Writes the current output buffer to a file under config.staticOut.path and a 
	 * sub directory according to the page's path key.
	 * @since 4.00
	 */
	private function write_static_output()
	{
		// construct target path
		$path = 
		$this->config->staticOut->path .
		($this->path === $this->config->defaults->rootPage ? "" : $this->path . "/");

		// ensure target path exists
		if (!file_exists($path))
		{
			mkdir($path, 0755, true); 	// Warning: mkdir(): File exists
		}

		// construct target file name
		$file = "index.html";

		// write output cache to file
		if (file_put_contents($path . $file, ob_get_contents()) === false)
		{
			debug("[warning] config.staticOut enabled, but file write failed.");
		}

		// scan all other files and directories for changes and copy them if necessary
		$exclude = 
		[
			".",
			"..",
			".htaccess",
			"index.php",
			"core.php",
			"core.config.json",
			trim($this->config->defaults->pagesDirectory, "/"),
			trim($this->config->staticOut->path, "/")
		];

		foreach (scandir(".") as $item) 
		{
			$source = $item;
			$target = $this->config->staticOut->path . $item;

			if (!in_array($source, $exclude) && dirmtime($source) > dirmtime($target))
			{
				dircopy($source, $target);
			}
		}
	}
}

/**
 * GLOBAL FUNCTIONS
 */

/**
 * Outputs any variable within <pre class="debug"> and some trace information in <h3> within.
 * @since 4.00
 */
function debug($var)
{
	$trace = debug_backtrace(1);
	echo "<pre class=\"debug\">";
	echo "<h3>" . basename($trace[0]["file"]) . ":" . $trace[0]["line"] . "</h3>";
	var_dump($var);
	echo "</pre>";
}
	
/**
 * Retrieves the last modify timestamp of a directory, respecting recursion.
 * @since 4.00
 * @param string directory to retrieve last modify time for
 * @return int last modified timestamp of the specified directory
 */
function dirmtime(string $path) : int
{
	if (!file_exists($path))
	{
		return 0;
	}

	$last_timestamp = filemtime($path);

	if (!is_dir($path))
	{
		echo "Warning: non-directory passed to dirmtime().";
		return $last_timestamp;
	}

	foreach (scandir($path) as $item)
	{
		if ($item != "." && $item != "..")
		{
			$mtime = filemtime($path . "/" . $item);

			if (is_dir($path . "/" . $item))
			{
				$mtime = dirmtime($path . "/" . $item);
			}

			if ($mtime > $last_timestamp)
			{
				$last_timestamp = $mtime;
			}
		}
	}

	return $last_timestamp;
}

/**
 * Copies a directory and all its contents recursively.
 * @since 4.00
 * @param string source directory
 * @param string destination directory
 */
function dircopy(string $source, string $target)
{
	if (!is_dir($source))
	{
		echo "Warning: non-directory source passed to dircopy().";
		return;
	}

	$dir = opendir($source);

	if (!is_dir($target))
	{
		mkdir($target);
	}

	while (($file = readdir($dir)) !== false)
	{ 
		if ($file != "." && $file != "..")
		{ 
			if (is_dir($source . "/" . $file))
			{
				dircopy($source . "/" . $file, $target . "/" . $file);
			}
			else
			{
				copy($source . "/" . $file, $target . "/" . $file);
			}
		}
	}

	closedir($dir); 
}

/**
 * Determines if an URI is external, e.g. if it starts with "http(s)://" or "www.".
 * @param string URI string, e.g. https://www.eurofurence.org (=> true) or home.php (=> false)
 * @return bool True, if URI starts with http(s):// or www.
 */
function is_external(string $uri) : bool
{
	return mb_ereg_match("(https?\:\/\/)|(www\.)", $uri, "");
}