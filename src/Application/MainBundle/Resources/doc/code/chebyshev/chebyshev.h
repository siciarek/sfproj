#ifndef __CHEBYSHEV_H__
#define __CHEBYSHEV_H__

/**
 * Funkcja przeliczaj¹ca wartoœæ z przedzia³u [a, b] na odpowiedni¹
 * wartoœæ z przedzia³u [-1, 1]
 */
double norm(double x, double a, double b) {
	return (x - 0.5 * (a + b)) * (2 / (b - a));
}

/**
 * Wielomian bazy Czebyszewa
 */
double T(unsigned int k, double x) {

	switch(k) {
		case 0:
			return 1;
		case 1:
			return x;
	}

	return 2 * x * T(k - 1, x) - T(k - 2, x);
}

/**
 * Wielomian interpolacyjny Czebyszewa
 */
double W(double x) {
	int k = 0;
	double sum = 0.0;
		
	for(k = 0; k < (sizeof(a) / sizeof(double)); k++) {
		sum += a[k] * T(k, x);
	}

	return sum;
}

#endif