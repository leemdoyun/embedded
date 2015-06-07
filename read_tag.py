import nfc
import nfc.snep,threading	
import MySQLdb

uid="s"  
url="http://115.68.116.250/embedded/embedded.html?uid="
def connected(tag): 
	global uid
	global url
	a = str(tag) 
	a = a.split()
	if(uid != a[4][4:]) :
		uid = a[4][4:]
		url += uid
		print uid
		return True
	else :
		print "same students!"
		return False
def connect_db():
	return MySQLdb.connect("server ip","db id","db pass","db name")

def check_student():
	global uid
	conn = connect_db()
	cursor = conn.cursor()	
	cursor.execute("select count(*) from student where uid = %s",(uid))
	row = cursor.fetchone()
	if(row[0] == 0):
		cursor.close()
		conn.close()
		return True
	else:
		cursor.close()
		conn.close()
		return False

def check_attend():
	global uid
	conn = connect_db()
	cursor = conn.cursor()
	cursor.execute("select l.lno from (select sno from student where uid = %s) as s, list l where l.stu_no = s.sno",(uid))
	row = cursor.fetchone()
	lno = row[0]

	cursor.execute("INSERT INTO time(list_no) VALUES(%s)",(lno))
	conn.commit()
	cursor.close()
	conn.close()
	
	return True

connected2 = lambda llc: threading.Thread(target=llc.run).start()  


clf = nfc.ContactlessFrontend('tty:AMA0:pn53x')

while True:
	if(clf.connect(rdwr={'on-connect': connected}) == True) :
		if(check_student() == True) :
			llc = clf.connect(llcp={'on-connect':connected2})  
			uri = nfc.ndef.Message(nfc.ndef.UriRecord(url))
			nfc.snep.SnepClient(llc).put(uri)
		else :					
			check_attend()
			print "sucess"
	else :
		print "in"		
##tty:AMA0:pn53x
