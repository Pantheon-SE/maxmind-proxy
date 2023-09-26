<!DOCTYPE html>
<html>

<head>
    <!-- Primary Meta Tags -->
    <title>Tracer - Network Performance Visualizer</title>
    <meta name="title" content="Tracer - Network Performance Visualizer" />
    <meta name="description"
        content="A simple web app and command line utility that visualizes network performance of traceroute." />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://maxmind.pantheon.support/tracer" />
    <meta property="og:title" content="Tracer - Network Performance Visualizer" />
    <meta name="author" content="Kyle Taylor">
    <meta property="og:description"
        content="A simple web app and command line utility that visualizes network performance of traceroute." />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://maxmind.pantheon.support/tracer" />
    <meta property="twitter:title" content="Tracer - Network Performance Visualizer" />
    <meta property="twitter:description"
        content="A simple web app and command line utility that visualizes network performance of traceroute." />

    <!-- Meta Tags Generated with https://metatags.io -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.10.2/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-arc@1.0.2/bin/leaflet-arc.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-polylineoffset@1.1.1/leaflet.polylineoffset.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-arrowheads@1.4.0/src/leaflet-arrowheads.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/tracer/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/tracer/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/tracer/favicon-16x16.png">
    <link rel="manifest" href="/icons/tracer/site.webmanifest">
    <link rel="mask-icon" href="/icons/tracer/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/icons/tracer/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/icons/tracer/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Tracer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="about" data-bs-toggle="modal"
                            data-bs-target="#aboutModal">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="run" data-bs-toggle="modal"
                            data-bs-target="#codeModal">Install</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main container">
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold text-body-emphasis">Trace Performance</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">
                    Tracer is a simple web app and command line utility that visualizes the performance of network
                    requests to a host using data provided by your computer to give an accurate
                    representation of end user experience vs running in a cloud environment.
                </p>
                <form class="form-card card-sm" id="get-code">
                    <div class="d-grid d-sm-flex justify-content-sm-center">
                        <div class="card-body row align-items-center">
                            <div class="col">
                                <input class="form-control form-control-lg form-control-borderless" id="target"
                                    placeholder="Enter domain or hostname" required>
                            </div> <!--end of col-->
                            <div class="col-auto">
                                <button class="btn btn-lg btn-success" type="submit">Run Locally</button>
                            </div> <!--end of col-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <h4 class="mb-3"><small id="hostname-title" style="font-weight: normal;"></small>
        </h4>
        <div class="row row-cols-1 row-cols-md-2 mb-2">
            <div class="col" id="host-cards"></div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Hop Map</div>
                    <div class="card-body">
                        <div id="map" style="height: 450px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <table id="mtrTable" class="table table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>Step</th>
                        <th>IP</th>
                        <th>Hostname</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Distance (km)</th>
                        <th>Average Time (ms)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be added here -->
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="aboutModalLabel">About</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tracer is inspired by traceroute-online.com as a way to visualize real traceroute
                            performance from an end client using the <code>mtr</code> utility. Running locally,
                            <code>mtr</code> will run a performant traceroute between the end client and destination,
                            then open a URL with the encoded JSON output to be parsed.
                        </p>
                        <p>It works slightly differently than online services because it needs to run on the client
                            itself to get a more realistic performance than a cloud server, often with limited
                            geographic availability.</p>

                        <p>Tracer needs the <code>mtr</code> utility to run. If you do not have it installed,
                            you can install on macOS using homebrew.</p>
                        <p>
                            <code class="bg-dark d-block p-3">brew instal mtr</code>
                        </p>
                        <p>Then you can download the script on your own, or run it as a one-liner, replacing
                            <code><hostname></code> with the target host.
                        </p>
                        <p>
                            <code
                                class="bg-dark d-block p-3">bash <(curl -fsSL https://maxmind.pantheon.support/tracer-script) $hostname</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="codeModalLabel">Code</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Run the code below to get your performance data. <strong>Note</strong>, it will ask for your
                            password as <code>mtr</code> requires <code>sudo</code> to run.</p>
                        <p>
                            <code id="code-snippet"
                                class="bg-dark d-block p-3">bash <(curl -fsSL https://maxmind.pantheon.support/tracer-script) $hostname</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top container-fluid">
        <div class="col-md-4 d-flex align-items-center">
            <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Kyle Taylor</span>
        </div>

        <div class="nav col-md-4 justify-content-end d-flex">
            <p><small>Inspired by <a href="https://traceroute-online.com">traceroute-online.com</a></small></p>
        </div>
    </footer>

    <script>
        /**
         * Get IP data from /datastudio endpoint.
         */
        async function fetchIpData(ip) {
            try {
                const response = await fetch(`/datastudio?ip=${ip}`);

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const data = await response.json();
                return data;
            } catch (error) {
                console.error("There was a problem:", error.message);
                throw error;
            }
        }

        /**
         * Get Hostname data from /datastudio endpoint.
         */
        async function fetchHostnameData(ip) {
            try {
                const response = await fetch(`/hostname?ip=${ip}`);

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const data = await response.json();
                return data;
            } catch (error) {
                console.error("There was a problem:", error.message);
                throw error;
            }
        }

        /**
         * Get flag emoji
         */
        function getFlagEmoji(countryCode) {
            const codePoints = countryCode
                .toUpperCase()
                .split('')
                .map(char => 127397 + char.charCodeAt());
            return String.fromCodePoint(...codePoints);
        }

        /**
         * Get a color.
         */
        function getColorByIndex(index) {
            const colors = [
                "#FF0000", "#00cc00", "#0000FF", "#00CCCC", "#CC00CC",
                "#FFFF00", "#FF7F00", "#7FFF00", "#00FF7F", "#007FFF",
                "#7F00FF", "#FF007F", "#7F7F7F", "#FF7F7F", "#7FFF7F",
                "#7F7FFF", "#7FFFFF", "#FF7FFF", "#FFFF7F", "#C0C0C0"
            ];

            // Use the modulus operator to wrap around if index is out of bounds
            return colors[index % colors.length];
        }

        /**
         * Slightly offset overlapping markers
         */
        function adjustLatLng(latLng, existingMarkers) {
            let maxIterations = 10; // Limit iterations to avoid infinite loops
            let adjusted = false;
            let newLatLng = latLng.slice();

            for (let i = 0; i < maxIterations; i++) {
                for (let existing of existingMarkers) {
                    if (
                        Math.abs(existing[0] - newLatLng[0]) < 0.01 &&
                        Math.abs(existing[1] - newLatLng[1]) < 0.01
                    ) {
                        // Adjust by a small fraction
                        newLatLng[0] += 0.2;
                        newLatLng[1] += 0.2;
                        adjusted = true;
                    }
                }
                if (!adjusted) break; // No adjustment needed, break out of loop
            }

            existingMarkers.push(newLatLng);
            return newLatLng;
        }

        /**
         * Get distance between two lat/lon points.
         */
        function getDistanceBetweenPoints(latlng1, latlng2) {
            let point1 = L.latLng(latlng1);
            let point2 = L.latLng(latlng2);
            return point1.distanceTo(point2) / 1000; // distance in kilometers
        }

        /**
         * Sanitize hostname input
         */
        function sanitizeHostname(hostname) {
            // Remove http:// and https://
            hostname = hostname.replace(/^https?:\/\//, '');

            // Remove paths and query strings
            hostname = hostname.split('/')[0];
            hostname = hostname.split('?')[0];
            hostname = hostname.split('#')[0];

            // Remove all characters that aren't alphanumeric, dots, or hyphens
            hostname = hostname.replace(/[^a-zA-Z0-9.-]/g, '');

            // Ensure it doesn't start or end with a hyphen or dot
            hostname = hostname.replace(/^-+|-+$|\.-|-.|^\./, '');

            return hostname;
        }

        /**
         * Main function
         */
        async function mainFunction() {

            // Handle form submission
            document.getElementById("get-code").addEventListener("submit", function (e) {
                e.preventDefault(); // Prevent the form from submitting

                let inputValue = document.getElementById("target").value.trim();  // Get the value from the input
                inputValue = sanitizeHostname(inputValue);
                document.getElementById('code-snippet').innerHTML = `bash <(curl -fsSL https://maxmind.pantheon.support/tracer-script) ${inputValue}`;
                const codeModal = new bootstrap.Modal('#codeModal');
                codeModal.show();

            });

            let rawData = decodeURIComponent(
                new URLSearchParams(window.location.search).get("data")
            );
            //   decode base64
            rawData = atob(rawData);
            let data = JSON.parse(rawData);
            console.log("data", data);

            // Add title
            document.getElementById("hostname-title").innerHTML = data?.report?.mtr?.dst;

            // Used for markers and distance mapping
            let existingMarkers = [];
            let previousLatLng = null;

            // Initialize Leaflet
            let map = L.map("map").setView([20, 0], 2); // Default view
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
            }).addTo(map);

            // Filter out locations without a loc value.
            let locationsPromises = data.report.hubs.map(async (location) => {
                const ipdata = await fetchIpData(location.host);
                const hostname = await fetchHostnameData(location.host);
                return { ...location, ...ipdata, ...hostname };
            });

            let locations = await Promise.all(locationsPromises);
            locations = locations.filter(location => location?.latitude);

            console.log("locations", locations);

            // Loop through each location to plot on map.
            locations.forEach(function (location, index) {

                // Add card to list.
                const asn = `AS${location.autonomous_system_number}`;
                const cardTemplate = `<div class="card mb-3">
                    <div class="card-header">${location.autonomous_system_organization} (<a href="https://ipinfo.io/${asn}" target="_blank">${asn}</a>) <span style="float: right;">${getFlagEmoji(location.country_iso)}</span></div>
                    <div class="card-body">
                        <div class="row row-cols-2 g-4 d-flex">
                            <div class=" flex-fill">
                                <div><p class="mb-0"><span class="fw-bold">${location.hostname}</span><br><small>Hostname</small></p></div>
                            </div>
                            <div class=" flex-fill">
                                <div><p class="mb-0"><span class="fw-bold">${location.host}</span><br><small>IP Address</small></p></div>
                            </div>
                        </div>
                        <div class="row row-cols-3 g-4">
                            <div class="col d-flex align-items-start">
                                <div>
                                    <p class="mb-0">
                                    <span class="fw-bold">${location.Avg}</span><br><small>Average (ms)</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex align-items-end">
                                <div>
                                    <p class="mb-0">
                                    <span class="fw-bold">${location.Best}</span><br><small>Best (ms)</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col d-flex align-items-start">
                                <div>
                                    <p class="mb-0">
                                    <span class="fw-bold">${location.Wrst}</span><br><small>Worst (ms)</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                document.getElementById("host-cards").innerHTML += cardTemplate;

                const locColor = getColorByIndex(index);
                if (location?.latitude && location?.longitude) {
                    let latLng = [parseFloat(location.latitude), parseFloat(location.longitude)];
                    latLng = adjustLatLng(latLng, existingMarkers); // Adjust the position if too close to another marker
                    let regionName = `${location?.city || "N/A"}, ${location.state || "N/A"
                        }, ${location.country || "N/A"}`;

                    L.circleMarker(latLng, {
                        color: locColor,
                        fillColor: locColor,
                        fillOpacity: 1,
                        radius: 5,
                    })
                        .addTo(map)
                        .bindTooltip(
                            `Step: ${index + 1}<br>IP: ${location.host}<br>Hostname: ${location.hostname || "N/A"
                            }<br>Location: ${regionName}`
                        )
                        .openTooltip();

                    // Calculate distance if not the first point
                    let distance = null;
                    if (previousLatLng) {
                        distance = getDistanceBetweenPoints(previousLatLng, latLng);
                    }
                    // Update previousLatLng for next iteration
                    previousLatLng = latLng;

                    // Add to table
                    let table = document
                        .getElementById("mtrTable")
                        .getElementsByTagName("tbody")[0];
                    let newRow = table.insertRow();

                    // Create a sequence of properties that you want to access from the location object
                    const sequence = [
                        "host",
                        "hostname",
                        "state",
                        "country",
                        "Avg",
                    ];

                    // Go through properties, add to table.
                    sequence.forEach((property, seqIndex) => {
                        const cellIndex = seqIndex + 1;
                        if (seqIndex == 0) {
                            newRow.insertCell(seqIndex).innerHTML = index;
                        }
                        let cellValue = location[property] || "N/A";
                        newRow.insertCell(cellIndex).innerHTML = cellValue;
                    });

                    // For the distance, you handle it separately since it has a different structure
                    newRow.insertCell(sequence.length).innerHTML = distance
                        ? distance.toFixed(2).toLocaleString()
                        : "N/A";

                    let prevLoc = locations[index - 1];
                    if (index > 0 && prevLoc?.latitude && prevLoc?.longitude) {
                        let previousLoc = locations[index - 1];
                        let previousLatLng = [
                            parseFloat(previousLoc.latitude),
                            parseFloat(previousLoc.longitude),
                        ];

                        let polyline = L.Polyline.Arc(previousLatLng, latLng, {
                            color: locColor,
                            weight: 3,
                            offset: index * 1.5
                        });
                        polyline.arrowheads({ frequency: 'endonly', size: '15px' });
                        polyline.addTo(map);

                    }
                }
            });
        }

        // Run main function
        document.addEventListener("DOMContentLoaded", function () {
            mainFunction();
        })
    </script>
</body>

</html>