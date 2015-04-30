Implementacja funkcji :math:`sin(x)` przy pomocy `Interpolacji Czebyszewa`
--------------------------------------------------------------------------

.. code-block:: json
    
    [
        [0.000000000000, 0.000000000000  ],
        [0.330693963536, 0.324699469205  ],
        [0.661387927072, 0.614212712690  ],
        [0.992081890607, 0.837166478263  ],
        [1.322775854143, 0.969400265939  ],
        [1.653469817679, 0.996584493007  ],
        [1.984163781215, 0.915773326655  ],
        [2.314857744750, 0.735723910673  ],
        [2.645551708286, 0.475947393037  ],
        [2.976245671822, 0.164594590281  ],
        [3.306939635358, -0.164594590281 ], 
        [3.637633598893, -0.475947393037 ], 
        [3.968327562429, -0.735723910673 ], 
        [4.299021525965, -0.915773326655 ], 
        [4.629715489501, -0.996584493007 ], 
        [4.960409453037, -0.969400265939 ], 
        [5.291103416572, -0.837166478263 ], 
        [5.621797380108, -0.614212712690 ], 
        [5.952491343644, -0.324699469205 ], 
        [6.283185307180, -0.000000000000 ]
    ]

.. code-block:: json

	[
		0.000000000003,
		-0.569230686397,
		0.000000000005,
		0.666916672377,
		0.000000000003,
		-0.104282368749,
		0.000000000001,
		0.006840633539,
		-0.000000000001,
		-0.000250006869,
		-0.000000000003,
		0.000005850271,
		-0.000000000003,
		-0.000000095327,
		-0.000000000003,
		0.000000001159,
		-0.000000000001,
		-0.000000000005,
		-0.000000000000,
		0.000000000001
	]
	
.. code-block:: c

    int x[] = {
        0.000000000000, 
        0.330693963536, 
        0.661387927072, 
        0.992081890607, 
        1.322775854143, 
        1.653469817679, 
        1.984163781215, 
        2.314857744750, 
        2.645551708286, 
        2.976245671822, 
        3.306939635358, 
        3.637633598893, 
        3.968327562429, 
        4.299021525965, 
        4.629715489501, 
        4.960409453037, 
        5.291103416572, 
        5.621797380108, 
        5.952491343644, 
        6.283185307180
    };

    int y[] = {
        0.000000000000,
        0.324699469205,
        0.614212712690,
        0.837166478263,
        0.969400265939,
        0.996584493007,
        0.915773326655,
        0.735723910673,
        0.475947393037,
        0.164594590281,
        0.164594590281,
        0.475947393037,
        0.735723910673,
        0.915773326655,
        0.996584493007,
        0.969400265939,
        0.837166478263,
        0.614212712690,
        0.324699469205,
        0.000000000000
    };



Dane wejściowe
==============

Jako danych wejściowych użyjemy 20 wartości funkcji :math:`sin(x)` dla argumentów
z przedziału :math:`(0, 2\pi)`, możemy je uzyskać z tablic matematycznych lub z aplikacji
zwracającej dane odpowiedniej jakości (`Matlab`, `R`):

.. php -r '$n = 0; foreach(range(0, 2 * M_PI, 2 * M_PI / 19) as $arg) { printf("x_%d = %.12f, y_%d = %.12f\n\n", $n, $arg, $n, sin($arg));$n++;}'

.. math::
   :nowrap:

    \begin{eqnarray}
    x_{0} = & 0.000000000000,\ \ y_{0} = & 0.000000000000 \\ 
    x_{1} = & 0.330693963536,\ \ y_{1} = & 0.324699469205 \\ 
    x_{2} = & 0.661387927072,\ \ y_{2} = & 0.614212712690 \\ 
    x_{3} = & 0.992081890607,\ \ y_{3} = & 0.837166478263 \\ 
    x_{4} = & 1.322775854143,\ \ y_{4} = & 0.969400265939 \\ 
    x_{5} = & 1.653469817679,\ \ y_{5} = & 0.996584493007 \\ 
    x_{6} = & 1.984163781215,\ \ y_{6} = & 0.915773326655 \\ 
    x_{7} = & 2.314857744750,\ \ y_{7} = & 0.735723910673 \\ 
    x_{8} = & 2.645551708286,\ \ y_{8} = & 0.475947393037 \\ 
    x_{9} = & 2.976245671822,\ \ y_{9} = & 0.164594590281 \\ 
    x_{10} = & 3.306939635358,\ \ y_{10} = & -0.164594590281 \\ 
    x_{11} = & 3.637633598893,\ \ y_{11} = & -0.475947393037 \\ 
    x_{12} = & 3.968327562429,\ \ y_{12} = & -0.735723910673 \\ 
    x_{13} = & 4.299021525965,\ \ y_{13} = & -0.915773326655 \\ 
    x_{14} = & 4.629715489501,\ \ y_{14} = & -0.996584493007 \\ 
    x_{15} = & 4.960409453037,\ \ y_{15} = & -0.969400265939 \\ 
    x_{16} = & 5.291103416572,\ \ y_{16} = & -0.837166478263 \\ 
    x_{17} = & 5.621797380108,\ \ y_{17} = & -0.614212712690 \\ 
    x_{18} = & 5.952491343644,\ \ y_{18} = & -0.324699469205 \\ 
    x_{19} = & 6.283185307180,\ \ y_{19} = & -0.000000000000
    \end{eqnarray}

Formuły
=======

W obliczeniach musimy używać argumentów z przedziału :math:`[-1, 1]` nie stanowi
to jednak problemu ponieważ przy pomocy równania:

.. math::

    x^{*} \in [a, b], x \in [-1, 1]

.. math::

    x^{*} = \frac{a + b}{2} + \frac{b - a}{2} x

.. math::

    x = \bigg(x^{*} - \frac{a + b}{2}\bigg) \cdot {\frac{2}{b - a}}

możemy przekształcić dowolną wartość z przedziału :math:`[a, b]` na odpowiednią
wartość z przedziału :math:`[-1, 1]`.

.. code-block:: c

    /**
     * Granice interpolowanego przedziału
     */
    double range[] = {0.000000000000, 6.283185307180};

    /**
     * Funkcja przeliczająca wartość z przedziału [a, b] na odpowiednią
     * wartość z przedziału [-1, 1]
     */
    double norm(double x, double a, double b) {
        return (x - 0.5 * (a + b)) * (2 / (b - a));
    }

Funkcje bazowe (tzw. `bazę Czebyszewa`) stanowi zbiór wielomianów określonych wzorem rekurencyjnym:

.. math::
   :nowrap:

    \begin{eqnarray}
        T_0(x) & = & 1 \\
        T_1(x) & = & x \\
        T_{k}(x) & = & 2 \cdot x \cdot T_{k-1}(x) - T_{k-2}(x)
    \end{eqnarray}

.. code-block:: c

    /**
     * Wielomian bazy Czebyszewa
     */
    double T(unsigned int k, double x) {

        x = norm(x, range[0], range[1]);

        switch(k) {
            case 0:
                return 1;
            case 1:
                return x;
        }

        return 2 * x * T(k - 1, x) - T(k - 2, x);
    }

Poniżej 10 pierwszych wielomianów z `bazy Czebyszewa`:

.. math::
   :nowrap:

    \begin{eqnarray}
        T_0(x) & = & 1 \\
        T_1(x) & = & x \\
        T_2(x) & = & 2x^2 - 1 \\
        T_3(x) & = & 4x^3 - 3x \\
        T_4(x) & = & 8x^4 - 8x^2 + 1 \\
        T_5(x) & = & 16x^5 - 20x^3 + 5x \\
        T_6(x) & = & 32x^6 - 48x^4 + 18x^2 - 1 \\
        T_7(x) & = & 64x^7 - 112x^5 + 56x^3 - 7x \\
        T_8(x) & = & 128x^8 - 256x^6 + 160x^4 - 32x^2 + 1 \\
        T_9(x) & = & 256x^9 - 576x^7 + 432x^5 - 120x^3 + 9x
    \end{eqnarray}

Wielomian interpolacyjny Czebyszewa ma postać:

.. math::
    
    W(x) = a_{0}T_{0}(x) + a_{1}T_{1}(x) + \cdots + a_{n}T_{n}(x)

.. math::

    W(x) = \sum_{k = 0}^{k = n} a_{k}T_{k}(x) 


.. code-block:: c
    
    /**
     * Wielomian interpolacyjny Czebyszewa
     */
    double W(double x, double a[]) {
        int k = 0;
        double sum = 0.0;

        for(k = 0; k < (sizeof(a) / sizeof(double)); k++) {
            sum += a[k] * T(k, x);
        }

        return sum;
    }

Wektor :math:`[ a_{0}, a_{1}, \cdots, a_{n} ]` wyliczymy z poniższego wzoru:

.. math::

    \begin{bmatrix}
        T_0(x_0) & T_1(x_0) & \cdots & T_n(x_0) \\
        T_0(x_1) & T_1(x_1) & \cdots & T_n(x_1) \\
        \vdots   & \vdots   & \ddots & \vdots   \\
        T_0(x_n) & T_1(x_n) & \cdots & T_n(x_n)
    \end{bmatrix}
        \cdot
    \begin{bmatrix}
        a_0    \\
        a_1    \\
        \vdots \\
        a_n
    \end{bmatrix}
        =
    \begin{bmatrix}
        y_0    \\
        y_1    \\
        \vdots \\
        y_n
    \end{bmatrix}
        \Rightarrow
    \begin{bmatrix}
        a_0    \\
        a_1    \\
        \vdots \\
        a_n
    \end{bmatrix}
        =
    \begin{bmatrix}
        y_0    \\
        y_1    \\
        \vdots \\
        y_n
    \end{bmatrix}
        \cdot
    \begin{bmatrix}
        T_0(x_0) & T_1(x_0) & \cdots & T_n(x_0) \\
        T_0(x_1) & T_1(x_1) & \cdots & T_n(x_1) \\
        \vdots   & \vdots   & \ddots & \vdots   \\
        T_0(x_n) & T_1(x_n) & \cdots & T_n(x_n)
    \end{bmatrix}^{-1}

Powyższe działania można przeprowadzić na kartce, lub przy pomocy aplikacji
wspierającej działanie na macierzach (`Matlab`, `R`), ponieważ musimy je wykonać
tylko raz dla danej funkcji, w samej aplikacji będziemy się posługiwać tylko
lista wartości.

Po wyliczeniu wartości wektora :math:`a` wynoszą:

.. math::

	[0.000000000003,
	-0.569230686397,
	0.000000000005,
	0.666916672377,
	0.000000000003,
	-0.104282368749,
	0.000000000001,
	0.006840633539,
	-0.000000000001,
	-0.000250006869,
	-0.000000000003,
	0.000005850271,
	-0.000000000003,
	-0.000000095327,
	-0.000000000003,
	0.000000001159,
	-0.000000000001,
	-0.000000000005,
	-0.000000000000,
	0.000000000001]
