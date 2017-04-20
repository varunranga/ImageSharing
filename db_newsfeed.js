db_post = connect('127.0.0.1:27017/CCBD_POST')
db_user = connect('127.0.0.1:27017/CCBD_USER')

// var user_id

var posts = new Array()

var post_ids = db_user.CCBD_USER.find({"user_id":user_id}).toArray()[0]['posts_on_newsfeed']
for(i = 0; i < post_ids.length; i++)
{
	var post = db_post.CCBD_POST.find({"post_id":post_ids[i]},{"_id":0}).toArray()[0]
	var user = db_user.CCBD_USER.find({"user_id":post['user_id']},{"_id":0}).toArray()[0]
	post["profile_picture"] = user["profile_picture"]
	post["user_name"] = user["first_name"] + " " + user["last_name"]

	posts.push(post)
}

printjson(posts)