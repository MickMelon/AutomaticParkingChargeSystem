
import socket

# Set all the constant definitions
IMAGE, HOST, PORT = "corsa.jpg", "127.0.0.1", 7777

# Create the socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

try:
    # Connect to server.
    sock.connect((HOST, PORT))

    # Load the image file.
    myfile = open(IMAGE, 'rb')

    # Turn the image file into a byte array that can be
    # sent on the network.
    filebytes = myfile.read()

    # Send all the bytes to the server
    sock.sendall(filebytes)

finally:
    # Shut that shit down
    sock.close()