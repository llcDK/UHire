#include <iostream>
#include <string>
#include <fstream>

using namespace std;

int main(int argc, char const *argv[])
{

   ofstream fout;
   fout.open("carImage.txt");
   for(int i = 0; i < 500; i++)
   {
      fout << ("images/car" + to_string(i) + ".jpg" + "\n");
   }

   return 0;
}