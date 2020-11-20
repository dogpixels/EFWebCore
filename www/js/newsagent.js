class NewsAgent
{
	// static url = "https://forum.eurofurence.org/index.php/board,6.0.html?action=.xml;sa=recent;limit=6";
	static url = "http://localhost/board,6.0.html.xml";

	static async get_news()
	{
		await fetch(NewsAgent.url)
		.then(response => response.text())
		.then(text => (new window.DOMParser()).parseFromString(text, "text/xml"))
		.then(responseXML => 
			{
				let ret = [];

				if (responseXML === null)
				{
					return Promise.reject("No response XML received.");
				}

				for (let i = 0; i < responseXML.documentElement.children.length; i++)
				{
					let item = responseXML.documentElement.children[i];

					ret.push
					({
						time: item.children[0].textContent.substr(0, 17),
						subject: item.children[2].textContent,
						link: item.children[8].textContent
					});
				}

				return Promise.resolve(ret);
			}
		);
	}
}