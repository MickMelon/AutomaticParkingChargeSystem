using System.Net.Sockets;
using System.Text;

namespace APCS.Server
{
    public class StateObject
    {
        public const int BufferSize = 1024;
        public byte[] Buffer { get; set; }
        public Socket WorkSocket { get; set; }    
        public StringBuilder DataString { get; set; }

        public StateObject()
        {
            WorkSocket = null;
            Buffer = new byte[BufferSize];
            DataString = new StringBuilder();
        }
    }
}