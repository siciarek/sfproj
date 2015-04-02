# language: pl

@all @available
Potrzeba biznesowa: Zapewnienie dostępności aplikacji
  Aby korzystać z aplikacji
  As a Użytkownik
  Chciałbym mieć pewność, że aplikacja jest dostępna

  @home
  Szablon scenariusza: Sprawdzenie czy działają wybrane strony
    Jeżeli odwiedzę stronę "<page>"
    Wtedy powinienem być na stronie "<page>"
    I zobaczę tekst "Strona główna"
    I kod statusu odpowiedzi powinien być równy 200
    Ale kod statusu odpowiedzi nie powinien być równy 404

    Przykłady:
      | page     |
      | /        |
