using System;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;

namespace APCS.Server
{
    public class AsyncSocketListener
    {
        public const int PORT = 11000;
        public static ManualResetEvent AllDone = new ManualResetEvent(false);

        public void Start()
        {
            var ipHostInfo = Dns.GetHostEntry(Dns.GetHostName());
            var ipAddress = ipHostInfo.AddressList[0];
            Console.WriteLine(ipAddress.ToString());
            var localEndPoint = new IPEndPoint(ipAddress, PORT);

            var listener = new Socket(ipAddress.AddressFamily, SocketType.Stream, ProtocolType.Tcp);

            try
            {
                listener.Bind(localEndPoint);
                listener.Listen(100);

                while (true)
                {
                    AllDone.Reset();

                    Console.WriteLine("Waiting for connection...");
                    listener.BeginAccept(new AsyncCallback(AcceptCallback), listener);

                    AllDone.WaitOne();
                }
            } 
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }

            Console.WriteLine("\nPress ENTER to continue...");
            Console.ReadLine();
        }

        public void AcceptCallback(IAsyncResult result)
        {
            AllDone.Set();

            var listener = (Socket) result.AsyncState;
            var handler = listener.EndAccept(result);

            var state = new StateObject(handler);
            handler.BeginReceive(state.Buffer, 0, StateObject.BUFFER_SIZE, 0,
                new AsyncCallback(ReadCallback), state);
        }

        public void ReadCallback(IAsyncResult result)
        {
            string content = String.Empty;

            var state = (StateObject) result.AsyncState;
            var handler = state.WorkSocket;

            int bytesRead = handler.EndReceive(result);

            if (bytesRead > 0)
            {
                state.StringBuilder.Append(Encoding.ASCII.GetString(state.Buffer, 0, bytesRead));
                content = state.StringBuilder.ToString();
                if (content.IndexOf("<EOF>") > -1)
                {
                    Console.WriteLine($"Read {content.Length} bytes from socket. \n Data: {content}");
                    string response = "";

                    // TODO: Check received reg against the database.
                    if (DummyCheckDb()) // if (reg exists in db)
                    {
                        if (content.Contains("<IN>"))
                        {
                            // If vehicle is entering car park, add entry with entry time
                            response = "SUCCESS";  
                        }
                        else if (content.Contains("<OUT>"))
                        {
                            // If vehicle is leaving car park, add entry with leaving time
                            response = "SUCCESS";  
                        }
                        else
                        {
                            response = "ENTRY_NOT_SPECIFIED";
                        }     
                    }
                    else
                    {
                        response = "NOT_FOUND";
                    }                  
                               
                    Send(handler, response);
                }
                else
                {
                    handler.BeginReceive(state.Buffer, 0, StateObject.BUFFER_SIZE, 0,
                        new AsyncCallback(ReadCallback), state);
                }
            }
        }

        private bool DummyCheckDb()
        {
            return false;
        }

        private void Send(Socket handler, string data)
        {
            byte[] byteData = Encoding.ASCII.GetBytes(data);
            handler.BeginSend(byteData, 0, byteData.Length, 0,
                new AsyncCallback(SendCallback), handler);
        }

        private void SendCallback(IAsyncResult result)
        {
            try
            {
                var handler = (Socket) result.AsyncState;
                int bytesSent = handler.EndSend(result);
                Console.WriteLine($"Sent {bytesSent} to the client.");

                handler.Shutdown(SocketShutdown.Both);
                handler.Close();
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
        }
    }
}