var db = connect('127.0.0.1:27017/CCBD_USER')

// var user_id

var user = db.CCBD_USER.find({"user_id":user_id},{"_id":0}).toArray()[0]

friends = user['friends']

newFriends = new Array()

for (i = 0; i < friends.length; i++)
{
	var friendUser = db.CCBD_USER.find({"user_id":friends[i]},{"_id":0}).toArray()[0]
	var toAppend = {
		'user_id' : friends[i],
		'name' : friendUser['first_name'],
		'profile_picture' : friendUser['profile_picture']
	}
	newFriends.unshift(toAppend)
}

user['friends'] = newFriends


pending_requests = user['pending_requests']

newPendingRequests = new Array()

for (i = 0; i < pending_requests.length; i++)
{
	var requestsUser = db.CCBD_USER.find({"user_id":pending_requests[i]},{"_id":0}).toArray()[0]
	var toAppend = {
		'user_id' : pending_requests[i],
		'name' : requestsUser['first_name'],
		'profile_picture' : requestsUser['profile_picture']
	}
	newPendingRequests.unshift(toAppend)
}

user['pending_requests'] = newPendingRequests




printjson(user)
// mongo --eval "var user_id='USR2';" db_get_user.js