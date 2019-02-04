using System;
using System.IO;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace APCS.Server
{
    /// <summary>
    /// Contains all the functions for working with OpenALPR.
    /// </summary>
    public static class OpenALPR
    {
        /// <summary>
        /// The private key used for OpenALPR Cloud API.
        /// </summary>
        private const string SECRET_KEY = "sk_b814e91e23aaf4bfc8403ff3";

        /// <summary>
        /// The HttpClient object used to interact with OpenALPR Cloud API.
        /// </summary>
        private static readonly HttpClient _httpClient = new HttpClient();

        /// <summary>
        /// Reads a registration number from the specified image.
        /// </summary>
        /// <param name="imagePath">The path to the vehicle image.</param>
        /// <returns>A new vehicle object with required data.</returns>
        public static async Task<Vehicle> ReadReg(string imagePath)
        {
            string response = await ProcessImage(imagePath);
            return new Vehicle(response);
        }

        /// <summary>
        /// Sends the vehicle image to OpenALPR gets the result.
        /// </summary>
        /// <param name="imagePath">The path to the vehicle image.</param>
        /// <returns>The result in JSON format.</returns>
        private static async Task<string> ProcessImage(string imagePath)
        {
            Byte[] bytes = File.ReadAllBytes(imagePath);
            string imagebase64 = Convert.ToBase64String(bytes);

            var content = new StringContent(imagebase64);

            var response = await _httpClient
                .PostAsync("https://api.openalpr.com/v2/recognize_bytes?recognize_vehicle=1&country=gb&secret_key=" + SECRET_KEY, content)
                .ConfigureAwait(false);

            var buffer = await response.Content.ReadAsByteArrayAsync().ConfigureAwait(false);
            var byteArray = buffer.ToArray();
            var responseString = Encoding.UTF8.GetString(byteArray, 0, byteArray.Length);

            return responseString;
        }
    }
}