db_post = connect('127.0.0.1:27017/CCBD_POST')
db_user = connect('127.0.0.1:27017/CCBD_USER')

// var view_id

var posts = db_post.CCBD_POST.find({"user_id":view_id},{"_id":0}).toArray()
for(i = 0; i < posts.length; i++)
{
	var user_id = posts[i].user_id
	var user = db_user.CCBD_USER.find({"user_id":user_id}).toArray()[0]
	posts[i]["profile_picture"] = user["profile_picture"]
	posts[i]["user_name"] = user["first_name"] + " " + user["last_name"]
}

printjson(posts)