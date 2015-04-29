Formuły matematyczne
--------------------

Do użycia formuł matematycznych wewnątrz dokumentacji `rst` może być potrzebna dodatkowa instalacja:

.. code-block:: bash

    $ tlmgr init-usertree
    $ sudo apt-get install xzdec
    $ tlmgr install titlesec
    $ tlmgr install framed
    $ tlmgr install threeparttable
    $ tlmgr install wrapfig
    $ tlmgr install upquote
    $ tlmgr install multirow
    $ sudo apt-get install texlive-latex-extra
    $ sudo apt-get install texlive-lang-polish
    $ sudo apt-get install dvipng


Formuły inline
==============

Since Pythagoras, we know that :math:`a^2 + b^2 = c^2`.

.. code-block:: rst

    Since Pythagoras, we know that :math:`a^2 + b^2 = c^2`.


Formuły blokowe
===============

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

.. code-block:: rst

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

--------------------------------------------------------------------------------

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

.. code-block:: rst

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

--------------------------------------------------------------------------------

.. math::

    \sum_{n=1}^{\infty} 2^{-n} = 1

.. code-block:: rst

    .. math::

        \sum_{n=1}^{\infty} 2^{-n} = 1

--------------------------------------------------------------------------------

.. math::

    \iiiint_V \mu(t,u,v,w) \,dt\,du\,dv\,dw

.. code-block:: rst

    \iiiint_V \mu(t,u,v,w) \,dt\,du\,dv\,dw

--------------------------------------------------------------------------------

.. math::

   (a + b)^2 = a^2 + 2ab + b^2

   (a - b)^2 = a^2 - 2ab + b^2

.. code-block:: rst

    .. math::

       (a + b)^2 = a^2 + 2ab + b^2

       (a - b)^2 = a^2 - 2ab + b^2

--------------------------------------------------------------------------------

.. math:: (a + b)^2 = a^2 + 2ab + b^2

.. code-block:: rst

    .. math:: (a + b)^2 = a^2 + 2ab + b^2

--------------------------------------------------------------------------------

.. math::
   :nowrap:

   \begin{eqnarray}
      y    & = & ax^2 + bx + c \\
      f(x) & = & x^2 + 2xy + y^2
   \end{eqnarray}

.. code-block:: rst

    .. math::
       :nowrap:

       \begin{eqnarray}
          y    & = & ax^2 + bx + c \\
          f(x) & = & x^2 + 2xy + y^2
       \end{eqnarray}
