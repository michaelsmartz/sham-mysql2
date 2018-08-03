/**
 * Created by TaroonG on 11/12/2017.
 */

importScripts('d3/d3.v3-3.5.17.min.js', 'dashboard-main.js');

onmessage = function (e) {
    var urls = e.data;
    var f = _get(urls[[0]]);
    f.then(function (data) {
        var response, msg, temp, flatD1, i, d1;
        msg = JSON.parse(data);

        if (urls[0].includes("getHeadcountData") || urls[0].includes("getTotalAssessmentData")) {

            temp = DashboardApp.getSimpleTotal(msg.response);
            response = Object.create({});
            if (urls[0].includes("getHeadcountData")) {
                Object.assign(response, {
                    url: 'getHeadcountData',
                    data: temp,
                    data1: msg.response
                });
            } else {
                //average score also as a simple display value
                var temp1 = DashboardApp.getAverageScore(msg.response);
                Object.assign(response, {
                    url: 'getTotalAssessmentData',
                    data: temp,
                    data1: temp1
                });
            }
            console.log(response);
        }

        if (urls[0].includes("getHeadcountDeptData")) {
            d1 = DashboardApp.dataGroupByFieldCount(msg.response, 'Department');
            var filtered = d1.filter(function (d) {
                return d.key !== 'Unspecified';
            });
            temp = DashboardApp.getSimpleTotal(filtered);

            flatD1 = [];
            i = 1;
            d1.forEach(function (row) {
                flatD1.push({
                    Id: i,
                    Department: row.key,
                    Size: row.values
                });
                i++;
            });

            response = Object.create({});
            Object.assign(response, {
                url: 'getHeadcountDeptData',
                data: temp,
                data1: flatD1
            });
        }

        if (urls[0].includes("getNewHiresData")) {
            response = Object.create({});

            Object.assign(response, {
                url: 'getNewHiresData',
                data: msg.response
            });
        }

        if (urls[0].includes("getAssetData")) {
            d1 = msg.response;
            flatD1 = [];
            i = 1;
            d1.forEach(function (row) {
                flatD1.push({
                    Id: i,
                    Description: row.Description,
                    Available: row.Available
                });
                i++;
            });

            response = Object.create({});
            Object.assign(response, {
                url: 'getAssetData',
                data: flatD1
            });
        }

        if (urls[0].includes("getQALastFiveDaysData")) {
            response = Object.create({});
            Object.assign(response, {
                url: 'getQALastFiveDaysData',
                data: msg.response
            });
        }

        if (urls[0].includes("getQAEvaluationScoresData")) {
            var temp = [{
                text: 'Headcount',
                size: msg.response
            }];
            response = Object.create({});
            Object.assign(response, {
                url: 'getQAEvaluationScoresData',
                data: msg.response,
                data1: msg.response
            });
        }

        if (urls[0].includes("getCourseData")) {
            d1 = msg.response;
            flatD1 = [];
            i = 1;
            d1.forEach(function (row) {
                flatD1.push({
                    Id: i,
                    Description: row.Description,
                    Participants: row.Participants
                });
                i++;
            });

            response = Object.create({});
            Object.assign(response, {
                url: 'getCourseData',
                data: flatD1
            });
        }

        if (urls[0].includes("getRewardCount")) {
            var temp = [{
                text: 'Headcount',
                size: msg.response
            }];
            response = Object.create({});
            Object.assign(response, {
                url: 'getRewardCount',
                data: temp,
                data1: msg.response
            });
        }

        if (urls[0].includes("getDisciplinaryActionCount")) {
            var temp = [{
                text: 'Headcount',
                size: msg.response
            }];
            response = Object.create({});
            Object.assign(response, {
                url: 'getDisciplinaryActionCount',
                data: temp,
                data1: msg.response
            });
        }

        postMessage(response);

    }).catch(function (e) {
        console.log('ptt ', e);
    });
};

var _get = function (url) {
    return new Promise(function (resolve, reject) { // Return a new promise.
        // Do the usual XHR stuff
        var req = new XMLHttpRequest();
        req.open('GET', url);
        req.onreadystatechange = function () {
            // This is called even on 404 etc, so check the status
            if (this.status == 200 && this.readyState == 4) {
                resolve(this.response); // Resolve the promise with the response text
            }
        };
        req.onerror = function () { // Handle network errors
            reject(Error("Network Error"));
        };
        req.send(); // Make the request
    });
};