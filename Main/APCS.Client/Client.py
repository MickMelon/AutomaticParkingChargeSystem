import socket

# Set all the constant definitions
IMAGE, HOST, PORT = "corsa.jpg", "192.168.1.8", 7777

MESSAGE = b'REQUEST<EOF>' # <EOF> signifies end of file.

def createsocket():
    return socket.socket(socket.AF_INET, socket.SOCK_STREAM)

def getpermission():
    sock = createsocket()
    sock.connect((HOST, PORT))
    sock.send(MESSAGE)
    received = sock.recv(1024)
    sock.close()
    return received.decode()

def sendimage():
    myfile = open(IMAGE, 'rb')
    filebytes = myfile.read()

    sock = createsocket()
    sock.sendall(filebytes)
    received = sock.recv(1024)
    sock.close()
    return received.decode()


# Create the socket
sock = createsocket()

try:
    # See if the server can let the client send the image
    # Server will return "ALLOW" or "DENY"
    message = getpermission()

    if message == "ALLOW":
        print("Acknowledgement received from server\nSending image...")
        message = sendimage()
        if message == "SUCCESS":
            print("Image was sent successfully")
        else:
            print("Something wrong happened")
    elif message == "DENY":
        print("The server denied the request")
    else:
        print("Server must be offline")

finally:
    # Shut that shit down
    sock.close()