
import os
import io
import picamera
import time
from datetime import datetime
from PIL import Image

#function to get the plate from alpr command
def getPlate(myCmd):
	
# because of how ALPR outputs detected plate numbers, need to alter format 
# by removing certain characters/substrings from output
# since all we care about is the value w/ the highest confidence 
	plateList = myCmd.replace('\t','')
	plateList = plateList.replace('confidence:','\n')
	plateList = plateList.replace('-','')

# now we split the output into a list 
# with new line caracter acting as delimiter
	plateList = plateList.split("\n")
	
# in ALPR output, the first plate listed is always the one with highest confidence score
# therefore,this is what the plate in the pcture is most likely to be
# this is the number we will extract from the list and send to the API
	plate = plateList[1];
# Finally, remove whitespace 
	plate = plate.strip(' ');

	#txtFile = "PlatesInPark.txt"
	#search = plate + "\n"

# Now to check if car if entering or leaving car park
# First search the text file of cars currently in the park for the extracted plate
	#if search in open(txtFile).read():
		#status="exit"
		# will need to store contents of file in a list
		# then remove current plate from it
		#regList=[]
		
		#f = open(txtFile, "r+")
		# add every line in the file to the empty list
		#for x in f:
			#regList.append(x)
		#remove the specific plate from the list
		#regList.remove(search)

		#write the amended list back to the file
		#for y in regList:
			#f.write(y)
		#f.close
		#print("car is leaving")
		#print("Plate removed from PlatesInPark.txt")
	#else:
		#status="entry"
		#f = open(txtFile, "a")
		#f.write(plate + "\n")
		#f.close
		#print("car is entering")
		#print("Plate stored in PlatesInPark.txt")
		
#If plate isn't in file, car is entering park. Append current plate to file
#If plate is in file, car is leaving. Remove current plate from file
	#print (plate)
	return plate

# declare camera object
camera = picamera.PiCamera()
difference = 20
pixels = 100
width = 640
height = 480

# functions for motion activated camera
def compare():
	camera.resolution = (100, 75)
	stream = io.BytesIO()
	camera.capture(stream, format = 'bmp')
	stream.seek(0)
	im = Image.open(stream)
	buffer = im.load()
	stream.close()
	return im, buffer
def newimage(width, height):
	time = datetime.now()
	filename = 'motion-%04d%02d%02d-%02d%02d%02d.jpg' % (time.year, time.month,time.day, time.hour,time.minute, time.second)
	camera.resolution = (width, height)
	camera.capture(filename)
	print 'Captured %s' % filename
	return filename

image1, buffer1 = compare()

timestamp = datetime.now()
plate = ''

while (True):
	image2, buffer2 = compare()

	changedpixels = 0
	for x in xrange(0, 100):
		for y in xrange(0, 75):
			pixdiff = abs(buffer1[x,y][1]- buffer2[x,y][1])
			if pixdiff > difference:		
				changedpixels += 1
	if changedpixels > pixels:
		filename = newimage(width, height)

	image1 = image2
	buffer1 = buffer2
	
	timestamp2 = datetime.now()
	print ("TImestamp 1:" + str(timestamp))
	print ("TImestamp 2:" +str(timestamp2))
	
	# shell command to get license plate no. from captured image
	myCmd = os.popen('alpr -c gb ' + filename).read()
	print (myCmd)
#if license plate was found, call function to extract most likely number from list
	if (myCmd != "No license plates found.\n" and myCmd != prevPlate):
		plate = getPlate(myCmd)
		import urllib.request
		contents = urllib.request.urlopen("https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=api&action=check").read()
		
	#elif (myCmd==prevPlate and (timestamp2-timestamp <=60000)):
		#most recent car is same one being detected, put it on a 1 minute delay
		#time.sleep(60)
	else:
		print("None found!")
