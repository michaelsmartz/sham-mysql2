// Import the modules

const chalk = require('chalk');
const fs = require('fs');
const fg = require('fast-glob');
const readdirp = require('readdirp');
const archiver = require('archiver');
var ProgressBar = require('progress');

const green = '\u001b[42m \u001b[0m';
const red = '\u001b[41m \u001b[0m';
// create a file to stream archive data to.
const directory = __dirname + '/../';
const filename = process.argv[2] || 'SmartZHub.zip';
const destination = directory + filename;

var output = fs.createWriteStream(destination);
var archive = archiver('zip');

// pipe archive data to the file
archive.pipe(output);

const folders = fg.sync(['*', '!.git', '!.history', '!.idea', '!build', '!dist', '!node_modules'], {onlyDirectories:true,deep:false});
const files = fg.sync(['*', '!*.js', '!.gitignore', '!.gitattributes']);
var total = folders.length + files.length;

let style = 'Zipping to ' + chalk.green.bold(filename) + ' [' + chalk.white(':bar') + '] ' + chalk.cyan.bold(':token');
var bar = new ProgressBar(style, {  complete: green, incomplete: ' ', total: total});

var settings = {
    root: '.',
    entryType: 'all',
    // Filter files
    fileFilter: [ '!*.js', '!.gitignore', '!.gitattributes', '!.env', '!.env.example' ],
    // Filter by directory
    directoryFilter: [ '!.git', '!.history', '!.idea', '!build', '!dist', '!node_modules' ],
    // Work with no sudbirectories deep
    depth: 0
};

// In this example, this variable will store all the paths of the files and directories inside the provided path
var allFilePaths = [];

readdirp(settings)
  .on('warn', function (err) { 
    console.error('something went wrong when processing an entry', err); 
  })
  .on('error', function (err) { 
    console.error('something went fatally wrong and the stream was aborted', err); 
  })
  .on('data', function (entry) { 
	allFilePaths.push({name: entry.name, directory:entry.stat.isDirectory()});
  })
  .on('end', function () {
	delayedLoop(allFilePaths, 1500, function(item, index) {
		if(item.directory){
			archive.directory(item.name, item.name);
		}else {
			archive.file(item.name, {name: item.name});
		}
		bar.tick(1,{'token': item.name});
	});
});

function delayedLoop(collection, delay, callback, context) {
	context = context || null;

	var i = 0,
	    nextInteration = function() {
	    	if (i === collection.length) {
				console.log('Please wait...');
				setTimeout(closeArchive, 20000);
	    		return;
	    	}

	    	callback.call(context, collection[i], i);
	    	i++;
	    	setTimeout(nextInteration, delay);
		};

	nextInteration();
}

function closeArchive(){
	console.log('done');
	archive.finalize();
}