const regStatConfig = {
    year: new Date().getFullYear(),
    state: 'open',
    data: 'https://www.eurofurence.org/data/reg/{year}.json',
    // data: 'https://wwwtest.eurofurence.org/data/reg/{year}.json',
    // data: 'http://localhost/_workfiles/temp/{year}.json'
}

class RegStats
{
    colors = {
        ci: {
            100: '#005953',
            80: '#338C86',
            60: '#66BFB9',
            50: '#7FD8D2',
            40: '#99F2EC',
            20: '#CCFFFF'
        },
        lanyard: {
            normal: '#49854b',
            sponsor: '#f5ca20',
            supersponsor: '#83559e',
            staff: '#e37529',
            director: '#dc333d'
        },
        interests: {
            animator: '#be89f3',
            artist: '#96c6fb',
            fursuiter: '#ff9d08',
            musician: '#08e5bd'
        }
    }
    
    /**
     * @param {String} datasource // json url, {year} is substituted by update()
     * @param {String} regstate   // open | staff | closed
     */
    constructor(datasource, regstate)
    {
        this.datasource = datasource;
        this.regstate = regstate;
    }

    async init()
    {
        this.data = {
            year: 0,
            convention: "",
            totalcount: 0,
            age: {},
            gender: {},
            status: {},
            shirtsize: {},
            country: {},
            sponsor: {},
            specialinterest: {
                animator: 0,
                artist: 0,
                fursuiter: 0,
                musician: 0
            }
        }

        this.charts = {
            "status": this.initStatus(),
            "types": this.initTypes(),
            "age": this.initAge(),
            "country": this.initCountry(),
            "size": this.initSize()
        }
        
        this.timestampContainer = document.getElementById('ef-rs-timestamp');
        this.rawContainer = document.getElementById('ef-rs-data-raw');
    }

    async update(year)
    {
        this.data = await this.fetch(year);

        this.initTotal();
        this.initInterests();
        this.updateStatus();
        this.updateTypes();
        this.updateAge();
        this.updateCountry();
        this.updateSize();
        
        this.timestampContainer.innerText = this.data.lastchangedatetimeutc;
        this.rawContainer.innerText = JSON.stringify(this.data, null, 4);
    }

    initTotal()
    {
        // total registrations
        document.getElementById('ef-rs-reg-total').innerText = this.data.totalcount;
        
        // reg open indicator
        const text = document.getElementById('ef-rs-reg-opening');
        const indicator = document.getElementById('ef-rs-reg-opening-indicator');
        indicator.classList.remove('ef-rs-reg-opening-indicator-animation');
        switch (this.regstate)
        {
            case 'closed':
                indicator.style.color = this.colors.lanyard.director;
                text.innerText = 'Registrations closed';
                break;
            case 'staff':
                indicator.style.color = this.colors.lanyard.staff;
                text.innerText = 'Staff registering';
                break;
            case 'open':
                indicator.style.color = this.colors.lanyard.normal;
                indicator.classList.add('ef-rs-reg-opening-indicator-animation');
                text.innerHTML = '<a href="https://identity.eurofurence.org" target="_blank">Registrations open</a>';
                break
        }
    }

    initStatus()
    {
        return new Chart(document.getElementById('ef-rs-reg-status'),
        {
            type: 'doughnut',
            data: {
                labels:
                [
                    "New",
                    "Approved",
                    // "Partially paid",
                    "Paid",
                    "Checked in",
                    // "Cancelled",
                    // "Waiting"
                ],
                datasets: [
                    {
                        data: [0, 0, 0, 0],
                        backgroundColor: [
                            this.colors.ci[20], // new,
                            this.colors.ci[40], // approved,
                            // partially paid,
                            this.colors.ci[60], // paid,
                            this.colors.ci[100], // checked in,
                            // cancelled,
                            // waiting
                        ]
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    htmlLegend: {
                        containerID: 'ef-rs-reg-status-legend',
                        values: [0, 0, 0, 0]
                    }
                },
                events: []
            },
            plugins: [htmlLegendPlugin]
        });
    }

    updateStatus()
    {
        const values = [
            this.data.status.new || 0,
            this.data.status.approved || 0,
            (this.data.status['partially paid'] || 0)
            + (this.data.status.paid || 0),
            this.data.status['checked in'] || 0,
            // this.data.status.cancelled || 0,
            // this.data.status.waiting || 0
        ];
        
        this.charts.status.data.datasets[0].data = values;
        this.charts.status.options.plugins.htmlLegend.values = values;

        this.charts.status.update();
    }

    initTypes()
    {
        return new Chart(document.getElementById('ef-rs-reg-types'),
        {
            type: 'doughnut',
            data: {
                labels: [
                    "Attendee",
                    "Sponsor",
                    "Super Sponsor"
                ],
                datasets: [
                    {
                        data: [0, 0, 0],
                        backgroundColor: [
                            this.colors.lanyard.normal,
                            this.colors.lanyard.sponsor,
                            this.colors.lanyard.supersponsor
                        ]
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    htmlLegend: {
                        containerID: 'ef-rs-reg-types-legend',
                        values: [0, 0, 0]
                    }
                },
                events: []
            },
            plugins: [htmlLegendPlugin]
        });
    }

    updateTypes()
    {
        const values = [
            this.data.sponsor.normal || 0,
            this.data.sponsor.sponsor || 0,
            this.data.sponsor.supersponsor || 0
        ];

        this.charts.types.data.datasets[0].data = values;
        this.charts.types.options.plugins.htmlLegend.values = values;

        this.charts.types.update();
    }

    initInterests()
    {
        document.getElementById('ef-rs-reg-interests-animators').innerText = this.data.specialinterest.animator;
        document.getElementById('ef-rs-reg-interests-artists').innerText = this.data.specialinterest.artist;
        document.getElementById('ef-rs-reg-interests-fursuiters').innerText = this.data.specialinterest.fursuiter;
        document.getElementById('ef-rs-reg-interests-musicians').innerText = this.data.specialinterest.musician;
    }

    initAge()
    {
        return new Chart(document.getElementById('ef-rs-age'),
        {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    updateAge()
    {
        const values = Object.values(this.data.age);
        const vhighi  = values.indexOf(Math.max(...values));

        this.charts.age.data.labels = Object.keys(this.data.age);
        this.charts.age.data.datasets[0].data = values;
        this.charts.age.data.datasets[0].backgroundColor = this.gradient(
            this.colors.ci[100],
            this.colors.ci[20],
            values.length,
            vhighi
        );
        
        this.charts.age.update();
    }

    initCountry()
    {
        document.getElementById('ef-rs-country-zoom').addEventListener('click', () => {
            // undefined == auto
            if (this.charts.country.options.scales.y.max == undefined) 
            {
                const values = Object.values(this.data.country);
                const vhighi = values.indexOf(Math.max(...values));
                
                // remove highest value, so the 2nd takes its place
                values[vhighi] = 0; 

                // add 20% ontop of max value and round to steps of 10
                this.charts.country.options.scales.y.max =
                    Math.ceil(Math.max(...values) * 1.2 / 10) * 10;
            }
            else
            {
                // let chartjs handle y axis scale automatically
                this.charts.country.options.scales.y.max = undefined;
            }
            
            this.charts.country.update();
        });

        return new Chart(document.getElementById('ef-rs-country'),
        {
            type: 'bar',
            data:  {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: this.colors.ci[60]
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    updateCountry()
    {
        this.charts.country.data.labels = Object.keys(this.data.country);
        this.charts.country.data.datasets[0].data = Object.values(this.data.country);
        this.charts.country.update();
    }
    
    initSize()
    {
        return new Chart(document.getElementById('ef-rs-reg-size'),
        {
            type: 'doughnut',
            data: {
                labels: ['XS', 'S', 'M', 'L', 'XL', 'XXL+', 'None'],
                datasets: [
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: [
                            this.colors.ci[20],
                            this.colors.ci[40],
                            this.colors.ci[50],
                            this.colors.ci[60],
                            this.colors.ci[80],
                            this.colors.ci[100],
                            '#dddddd'
                        ]
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    htmlLegend: {
                        containerID: 'ef-rs-reg-size-legend',
                        values: [0, 0, 0, 0, 0, 0, 0],
                        columns: 2
                    }
                },
                events: []
            },
            plugins: [htmlLegendPlugin]
        });
    }

    updateSize()
    {
        const values = Object.values(this.data.shirtsize);
        const rest = this.data.totalcount - values.reduce((s, a) => s + a, 0);

        this.charts.size.data.datasets[0].data = [...values, rest];
        this.charts.size.options.plugins.htmlLegend.values = [...values, rest];
        this.charts.size.update();
    }

    async fetch(year)
    {
        let url = this.datasource.replace('{year}', year);

        // prevent caching for live data
        url += `?${Date.now()}`

        var data = null;

        try {
            data = await (await fetch(url)).json();
            if (!data)
            {
                console.info("[ef-regstats] data", data);
                throw "malformed data";
            }
        }
        catch(ex)
        {
            console.error(`[ef-regstats] failed to load ${url}, reason: ${ex}`);
            return;
        }

        return data;
    }

    /**
     * @param {String} peak     // darkest color
     * @param {String} end      // lightest color
     * @param {Number} steps    // number of bars
     * @param {Number} center   // index of highest bar
     * @return {Array<String>}  // array of colors
     */
    gradient(peak, end, steps, center = 0)
    {
        end = this.hexToRgb(end);
        peak = this.hexToRgb(peak);

        // left part gradient including center
        let a = [];
        for (let i = steps - center - 1; i < steps; i++)
        {
            a.push(
                this.rgbToHex(
                    this.interp(end.r, peak.r, steps, i),
                    this.interp(end.g, peak.g, steps, i),
                    this.interp(end.b, peak.b, steps, i)
                )
            );
        }

        // right part
        let b = [];
        for (let i = 1; i < steps - center; i++)
        {
            b.push(
                this.rgbToHex(
                    this.interp(peak.r, end.r, steps, i),
                    this.interp(peak.g, end.g, steps, i),
                    this.interp(peak.b, end.b, steps, i)
                )
            );
        }

        return [...a, ...b];
    }

    interp(start, end, steps, step)
    {
        return Math.round(start + ((end - start) / (steps - 1)) * step);
    }

    hexToRgb(hex)
    {
        return {
            r: parseInt(hex[1] + hex[2], 16),
            g: parseInt(hex[3] + hex[4], 16),
            b: parseInt(hex[5] + hex[6], 16)
        };
    }

    rgbToHex(r, g, b)
    {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }
}

const htmlLegendPlugin = {
    id: 'htmlLegend',
    afterUpdate(chart, args, options)
    {
        const container = document.getElementById(options.containerID);

        // Remove old legend items
        while(container.firstChild)
            container.firstChild.remove();

        // reuse the built-in legendItems generator
        const items = chart.options.plugins.legend.labels.generateLabels(chart);

        const table = document.createElement('table');

        const numColumns = chart.options.plugins.htmlLegend.columns || 1;
        const numRows = Math.ceil(items.length / numColumns);

        for (let row = 0; row < numRows; row++)
        {
            const tr = document.createElement('tr');
            
            for (let col = 0; col < numColumns; col++)
            {
                const i = row + col * numRows; // determine current item index
                if (i < items.length)
                {
                    const item = items[i];

                    // color box
                    const td1 = document.createElement('td');
                    td1.onclick = () => {
                        chart.toggleDataVisibility(item.index);
                        chart.update();
                    };
                    const div = document.createElement('div');
                    div.style.background = item.fillStyle;
                    div.style.borderColor = item.strokeStyle;
                    div.style.borderWidth = item.lineWidth + 'px';
                    td1.appendChild(div);
                    tr.appendChild(td1);

                    // value
                    const td2 = document.createElement('td');
                    td2.onclick = () => {
                        chart.toggleDataVisibility(item.index);
                        chart.update();
                    };
                    const value = document.createElement('span');
                    value.style.color = item.fontColor;
                    value.style.textDecoration = item.hidden ? 'line-through' : '';
                    value.innerText = chart.options.plugins.htmlLegend.values[i];
                    td2.appendChild(value);
                    tr.appendChild(td2);

                    // text
                    const td3 = document.createElement('td');
                    td3.onclick = () => {
                        chart.toggleDataVisibility(item.index);
                        chart.update();
                    };
                    const text = document.createElement('span');
                    text.style.color = item.fontColor;
                    text.style.textDecoration = item.hidden ? 'line-through' : '';
                    text.innerText = item.text;
                    td3.appendChild(text);
                    tr.appendChild(td3);
                }
            }

            table.appendChild(tr);
        }

        container.appendChild(table);
    }
};

const regstats = new RegStats(regStatConfig.data, regStatConfig.state);

regstats.init();
regstats.update(regStatConfig.year);

const timer_set = 10; // seconds
var timer_cur = timer_set;
const timer_div = document.getElementById('ef-rs-update');

setInterval(() => {
    if (--timer_cur < 0)
    {
        regstats.update(regStatConfig.year);
        timer_cur = timer_set;
    }
    timer_div.innerText = timer_cur;
}, 1000);