import socket

# Set all the constant definitions
IMAGE, HOST, PORT = "corsa.jpg", "192.168.1.8", 7777

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
sock.connect((HOST, PORT))

msg = ''
while 1:
    msg = ''
    #receive = sock.recv(1024)
    #print(receive.decode())
    msg = input('>>')

    if msg == 'img':
        myfile = open(IMAGE, 'rb')
        img = b'<IMG>'
        filebytes = myfile.read()
        filebytes += img
        sock.sendall(filebytes)
        print('Image sent')
        success = sock.recv(1024)
        print(success.decode())
    elif msg == 'quit':
        break
    else:
        msg += '<TXT>'
        print(msg)
        sock.send(msg.encode())

sock.close()