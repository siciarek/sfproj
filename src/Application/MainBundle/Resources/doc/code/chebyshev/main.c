#include <stdio.h>
#include <stdlib.h>

#include <sin.h>

double samples[] = {             
0.000000000000, 0.000000000000,
0.100000000000, 0.099833416647,
0.200000000000, 0.198669330795,
0.300000000000, 0.295520206661,
0.400000000000, 0.389418342309,
0.500000000000, 0.479425538604,
0.600000000000, 0.564642473395,
0.700000000000, 0.644217687238,
0.800000000000, 0.717356090900,
0.900000000000, 0.783326909627,
1.000000000000, 0.841470984808,
1.100000000000, 0.891207360061,
1.200000000000, 0.932039085967,
1.300000000000, 0.963558185417,
1.400000000000, 0.985449729988,
1.500000000000, 0.997494986604,
1.600000000000, 0.999573603042,
1.700000000000, 0.991664810452,
1.800000000000, 0.973847630878,
1.900000000000, 0.946300087687,
2.000000000000, 0.909297426826,
2.100000000000, 0.863209366649,
2.200000000000, 0.808496403820,
2.300000000000, 0.745705212177,
2.400000000000, 0.675463180551,
2.500000000000, 0.598472144104,
2.600000000000, 0.515501371821,
2.700000000000, 0.427379880234,
2.800000000000, 0.334988150156,
2.900000000000, 0.239249329214,
3.000000000000, 0.141120008060,
3.100000000000, 0.041580662433,
3.200000000000, -0.058374143428,
3.300000000000, -0.157745694143,
3.400000000000, -0.255541102027,
3.500000000000, -0.350783227690,
3.600000000000, -0.442520443295,
3.700000000000, -0.529836140908,
3.800000000000, -0.611857890943,
3.900000000000, -0.687766159184,
4.000000000000, -0.756802495308,
4.100000000000, -0.818277111064,
4.200000000000, -0.871575772414,
4.300000000000, -0.916165936749,
4.400000000000, -0.951602073890,
4.500000000000, -0.977530117665,
4.600000000000, -0.993691003633,
4.700000000000, -0.999923257564,
4.800000000000, -0.996164608836,
4.900000000000, -0.982452612624,
5.000000000000, -0.958924274663,
5.100000000000, -0.925814682328,
5.200000000000, -0.883454655720,
5.300000000000, -0.832267442224,
5.400000000000, -0.772764487556,
5.500000000000, -0.705540325570,
5.600000000000, -0.631266637872,
5.700000000000, -0.550685542598,
5.800000000000, -0.464602179414,
5.900000000000, -0.373876664830,
6.000000000000, -0.279415498199,
6.100000000000, -0.182162504272,
6.200000000000, -0.083089402818
};

int main(int argc, char** argv) {
    int x = 0;

    for(x = 0; x < (sizeof(samples)/sizeof(double)); x += 2) {
        double sample = samples[x];
        double errabs = (sin(sample) - samples[x + 1]);  
        double err = errabs / samples[x + 1];
        printf("%.12f, %.12f, %.12f, %.12f, %.12f\n", sample, sin(sample), samples[x + 1], errabs, err);
    }

    return EXIT_SUCCESS;
}
