import socket

# Set all the constant definitions
IMAGE, HOST, PORT = "corsa.jpg", "127.0.0.1", 7777


sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

sock.connect((HOST, PORT))

MESSAGE = b'REQUEST<TXT>'
sock.send(MESSAGE)
msg = ''
while msg != 'quit':
    msg = ''
    receive = sock.recv(1024)
    print(receive.decode())
    msg = input('Send a message >>')

    if msg == 'img':
        myfile = open(IMAGE, 'rb')
        img = b'<IMG>'
        filebytes = myfile.read()
        filebytes += img
        sock.sendall(filebytes)
        print('Image sent')
    else:
        msg += '<TXT>'
        print(msg)
        sock.send(msg.encode())