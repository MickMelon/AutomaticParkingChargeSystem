using System.Net.Sockets;
using System.Text;

namespace APCS.Server
{
    public class StateObject
    {
        public const int BUFFER_SIZE = 1024;

        public Socket WorkSocket { get; set; }
        public byte[] Buffer { get; set; }
        public StringBuilder StringBuilder { get; set; }

        public StateObject(Socket workSocket)
        {
            WorkSocket = workSocket;
            Buffer = new byte[BUFFER_SIZE];
            StringBuilder = new StringBuilder();
        }
    }
}