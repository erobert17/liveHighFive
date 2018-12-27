//casperjs --ignore-ssl-errors=true --ssl-protocol=any scrape.js
var fs = require('fs');
var utils = require('utils');

var casper = require('casper').create({
    clientScripts: ["jquery-migrate-1.4.1.min.js"],
    //verbose: true,
    //logLevel: "debug",
    viewportSize: {
        width: 1200,
        height: 700
    },
    pageSettings: {
        loadImages:  true,        // do not load images
        loadPlugins: true,         // do not load NPAPI plugins (Flash, Silverlight, ...)
        webSecurityEnabled: false
    }

});

var finalRecords = [];
//User Agent

//casper.userAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1');//Ff
//casper.userAgent('Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');//Chrome
casper.userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A');//Safari
//casper.userAgent("Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16");
casper.start('http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=1610+Westminster+Place&citystatezip=Ann%2CArbor%2C+MI');

casper.then(function(){
    /*
    var thisReturn = this.evaluate(function(){
        return document.documentElement.innerHTML;
    });
    
    this.echo('dd' + thisReturn);
    */
    var xmlout = this.page.content;
    this.echo(xmlout)
});



casper.then(function(){
    /*this.capture('screen.png', {
        top: 0,
        left: 0,
        width: 1300,
        height: 720
    });*/
})


casper.run(function() {
    this.echo('').exit();
});

    /*
    this.capture('screen.png', {
        top: 0,
        left: 0,
        width: 1300,
        height: 720
    });*/
