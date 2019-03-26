using System;
using System.Threading.Tasks;

namespace APCS.Server
{
    /// <summary>
    /// The class that starts the program up.
    /// </summary>
    public class Program
    {
        /// <summary>
        /// The method that starts the program up.
        /// </summary>
        public static void Main(string[] args)
        {
            var listener = new AsyncSocketListener();
            listener.Start();
        }
    }
}
