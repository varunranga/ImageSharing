var db = connect('127.0.0.1:27017/CCBD_USER')

// var send_id
// var receive_id

// For the sender
send_user = db.CCBD_USER.find({"user_id":send_id}).toArray()[0]
send_user['requested'].splice(send_user['requested'].indexOf(receive_id), 1)

db.CCBD_USER.update({"user_id":send_id}, send_user)

receive_user = db.CCBD_USER.find({"user_id":receive_id}).toArray()[0]
receive_user['pending_requests'].splice(receive_user['pending_requests'].indexOf(send_id), 1)

db.CCBD_USER.update({"user_id":receive_id}, receive_user)