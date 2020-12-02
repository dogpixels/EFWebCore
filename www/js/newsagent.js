class NewsAgent
{
	static url = "https://forum.eurofurence.org/index.php/board,6.0.html?action=.xml;sa=recent;limit=6";
	static subjectLength = 32;

	static async fetch()
	{
		let ret = [];
		
		const response = await fetch(NewsAgent.url);
		
		if (!response.ok)
		{
			console.error("[EF-Web NewsAgent] Fetching news from EF Forum failed.");
			return ret;
		}

		const responseXML = (new window.DOMParser()).parseFromString(await (response).text(), "text/xml");
		if (responseXML === null)
		{
			console.error("[EF-Web NewsAgent] Parsing news from EF Forum failed.");
			return ret;
		}

		for (let i = 0; i < responseXML.documentElement.children.length; i++)
		{
			const item = responseXML.documentElement.children[i];

			const time_raw = item.children[0].textContent;
			const subject_raw = item.children[2].textContent;
			const link_raw = item.children[8].textContent;

			// define time
			let time = time_raw.substr(0, 17); // DD.MM.YYYY, HH:mm:ss => DD.MM.YYYY, HH:mm

			let timestamp = Date.UTC(
				+time.substr(6, 4),		// year
				+time.substr(3, 2) - 1,	// month
				+time.substr(0, 2),		// day
				+time.substr(12, 2),	// hour
				+time.substr(15, 2)		// minute
			) / 1000;

			// define subject
			let subject =
				subject_raw.length <= NewsAgent.subjectLength ? 
				subject_raw : 
				subject_raw.substr(0, subject_raw.lastIndexOf(" ", NewsAgent.subjectLength)) + "…";
			
			// define link
			let link = link_raw;
			
			ret.push({time: time, timestamp: timestamp, subject: subject, link: link});
		}

		// console.info("[EF-Web NewsAgent] Results:", ret);

		return ret;
	}
}

// must be here because EF severs don't allow inline scripts
window.onload = async () => 
{
	const items = await NewsAgent.fetch();

	// prepare news div
	news.innerText = items.length === 0? "error loading announcements :(" : "";

	// fill news div
	for (let i = 0; i < items.length; i++)
	{
		const item = items[i];
		news.innerHTML += `<article><a href="${item.link}" target="_blank" data-lastmodified="${item.timestamp}"><cite>${item.subject}</cite><time>${item.time}</time></a></article>`;
	}
}