var Connection = require('tedious').Connection;
var config = {
    server: 'localhost', //update me
    authentication: {
        type: 'default',
        options: {
            userName: 'root', //update me
            password: '"K*d0e=a' //update me
        }
    },
    options: {
        // If you are on Microsoft Azure, you need encryption:
        encrypt: true,
        database: 'wakoky' //update me
    }
};
var connection = new Connection(config);
connection.on('connect', function(err) {
    // If no error, then good to proceed.  
    console.log("Connected");
    executeStatement();
});

var Request = require('tedious').Request;
var TYPES = require('tedious').TYPES;

function createPlaylist() {
    request = new Request("SELECT id FROM users WHERE username = 'hugo'", function(err) {
        if (err) {
            console.log(err);
        }
    });
    var result = "";
    request.on('row', function(columns) {
        columns.forEach(function(column) {
            if (column.value === null) {
                console.log('NULL');
            } else {
                result += column.value + " ";
            }
        });
        console.log(result);
        result = "";
    });

    request.on('done', function(rowCount, more) {
        console.log(rowCount + ' rows returned');
    });
    connection.execSql(request);
}

function mysql_real_escape_string(str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function(char) {
        switch (char) {
            case "\0":
                return "\\0";
            case "\x08":
                return "\\b";
            case "\x09":
                return "\\t";
            case "\x1a":
                return "\\z";
            case "\n":
                return "\\n";
            case "\r":
                return "\\r";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "\\" + char; // prepends a backslash to backslash, percent,
                // and double/single quotes
            default:
                return char;
        }
    });
}
/*
function createPlaylist() { //create playlist
    var query, username, user_id, result;
    var name = mysql_real_escape_string(document.forms["formAddPlaylist"]["fname"].value);
    var error = 0;
    query = "SELECT id FROM users WHERE username='" + username + "'";
    result = dbConnection.query(query);
    if (!result.isValid) {
        alert("Error");
    } else {
        user_id = result.value("id");
    }
    // form validation: ensure that the form is correctly filled
    if (empty(name)) {
        error++;
        alert("Name is required");
    }

    //check if name used
    query = "SELECT * FROM playlists WHERE name='" + name + "' AND user_id='" + user_id + "'";
    result = dbConnection.query(query);
    if (!result.isValid) {
        alert("Error");
    }
    if ($error == 0) {
        query = "INSERT INTO playlists (name, user_id) VALUES('$name', '$user_id')";
        result = dbConnection.query(query);
    }
    return (false);
}
*/