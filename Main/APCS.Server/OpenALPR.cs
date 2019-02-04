using System;
using System.IO;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace APCS.Server
{
    public class OpenALPR
    {
        private const string SECRET_KEY = "sk_b814e91e23aaf4bfc8403ff3";
        private static readonly HttpClient _httpClient = new HttpClient();

        public static async Task<string> ProcessImage(string imagePath)
        {
            byte[] bytes = File.ReadAllBytes(imagePath);
            string imageBase64 = Convert.ToBase64String(bytes);

            var content = new StringContent(imageBase64);
            var response = await _httpClient.PostAsync(
                "https://api.openalpr.com/v2/recognize_bytes?recognize_vehicle=1&country=us&secret_key=" + SECRET_KEY,
                content)
                .ConfigureAwait(false);

            var buffer = await response.Content.ReadAsByteArrayAsync().ConfigureAwait(false);
            var byteArray = buffer.ToArray();
            var responseString = Encoding.UTF8.GetString(byteArray, 0, byteArray.Length);

            return responseString;
        }
    }
}