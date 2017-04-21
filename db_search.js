var db = connect('127.0.0.1:27017/CCBD_USER')

// var first_name
// var last_name

if (last_name == '')
{
	var found1 = db.CCBD_USER.find({"first_name":{$regex:'.*'+first_name+'.*',$options:"-i"}},{"_id":0}).toArray()
//	var found2 = db.CCBD_USER.find({"last_name":{$regex:'.*'+last_name+'.*',$options:"-i"}},{"_id":0}).toArray()
	var found = new Array()
	for (i = 0; i < found1.length; i++)
	{
		found.push(found1[i])
	}

//	for (i = 0; i < found2.length; i++)
//	{
//		found.push(found2[i])
//	}
}
else
{
	var found1 = db.CCBD_USER.find({$or:[{"first_name":{$regex:'.*'+first_name+'.*',$options:"-i"}},{"last_name":{$regex:'.*'+last_name+'.*'}}]},{"_id":0}).toArray()
	var found2 = db.CCBD_USER.find({$or:[{"last_name":{$regex:'.*'+first_name+'.*',$options:"-i"}},{"first_name":{$regex:'.*'+last_name+'.*'}}]},{"_id":0}).toArray()
	for (i = 0; i < found1.length; i++)
	{
		found.push(found1[i])
	}

	for (i = 0; i < found2.length; i++)
	{
		found.push(found2[i])
	}	
}

printjson(found)