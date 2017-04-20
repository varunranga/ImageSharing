var db = connect('127.0.0.1:27017/CCBD_USER')

// var email_id
// var password

var search = db.CCBD_USER.find({$and:[{"email_id":email_id},{"password":password}]},{"_id":0}).toArray()[0]

if (search != undefined)
{
	printjson(search);
}
else
{
	var json = {
		'problem' : "Email ID or Password isn't correct."
	}
	printjson(json);
}