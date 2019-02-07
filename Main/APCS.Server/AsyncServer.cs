using System;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;

namespace APCS.Server
{
    public class AsyncServer
    {
        public static ManualResetEvent AllDone = new ManualResetEvent(false);

        private static TcpListener _listener { get; set; }
		private static bool _accept { get; set; } = false;

        public static void StartServer(string ip = "127.0.0.1", int port = 7777)
        {
            var address = IPAddress.Parse(ip);
			_listener = new TcpListener(address, port);

			_listener.Start();

			Console.WriteLine($"Server started. Listening to TCP clients at 127.0.0.1:{port}");
            Listen();
        }

        private static void Listen()
        {
            if (_listener != null)
            {
                while (true)
                {
                    AllDone.Reset();

                    Console.WriteLine("Waiting for a client...");
                    _listener.BeginAcceptSocket(new AsyncCallback(AcceptCallback), _listener);

                    AllDone.WaitOne();
                }
            }
        }

        private static void AcceptCallback(IAsyncResult result)
        {
            AllDone.Set();

            Console.WriteLine("Accepted client...");

            var listener = (TcpListener) result.AsyncState;
            var handler = listener.EndAcceptSocket(result);

            var state = new StateObject();
            state.WorkSocket = handler;
            handler.BeginReceive(state.Buffer, 0, StateObject.BufferSize, 0,
                new AsyncCallback(ReadCallback), state);
        }

        private static void ReadCallback(IAsyncResult result)
        {
            Console.WriteLine("Reading from client...");
            string content = "";

            var state = (StateObject) result.AsyncState;
            var handler = state.WorkSocket;

            int bytesRead = handler.EndReceive(result);

            if (bytesRead > 0)
            {
                state.DataString.Append(Encoding.ASCII.GetString(state.Buffer, 0, bytesRead));

                content = state.DataString.ToString();
                if (content.IndexOf("<EOF>") > -1)
                {
                    Console.WriteLine($"Read {content.Length} bytes from socket. \nData: {content}");
                    Send(handler, content);
                }
                else
                {
                    handler.BeginReceive(state.Buffer, 0, StateObject.BufferSize, 0,
                        new AsyncCallback(ReadCallback), state);
                }
            }
        }

        private static void Send(Socket handler, String data)
        {
            byte[] byteData = Encoding.ASCII.GetBytes(data);
            handler.BeginSend(byteData, 0, byteData.Length, 0,
                new AsyncCallback(SendCallback), handler);
        }

        private static void SendCallback(IAsyncResult result)
        {
            try
            {
                var handler = (Socket) result.AsyncState;

                int bytesSent = handler.EndSend(result);
                Console.WriteLine($"Sent {bytesSent} to the client.");

                handler.Shutdown(SocketShutdown.Both);
                handler.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.ToString());
            }
        }
    }
}