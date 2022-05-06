
@section('title')
Formular
@endsection
@section('content')

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Formular</title>
  </head>
  <body>
  
      <div class="container p-5 my-5 border">  <!-- Formular für Daten -->
        <h1 style="text-align:center;">Klausurtermin prüfen</h1>
        <div class="container p-5 my-5 border">
            <form action="{{url('/getData')}}" method="POST"><!-- Wenn Formular bestätigt, rufe Methode /getData -->
                @csrf
                <div class="mb-3 mt-3">
                    <label for="Datum" class="form-label">Datum:</label>
                    <input type="date" class="form-control" id="klausurDatum" placeholder="Datum" name="klausurDatum">
                </div>
        </div>

      <div class="container p-5 my-5 border"> <!-- Abfrage ob Termin am Wochenende liegt -->
          <div class="container">
                <p>Wochenende prüfen</p>
          </div>
          <div class="container">
              <input type="radio" name="radioBtn" value="valueJa"> Ja
              <input type="radio" name="radioBtn" value="valueNein"> Nein
          </div>
      </div>

        <div class="container p-5 my-5 border"> <!-- Abfrage Name der Klausur -->
            <div class="mb-3 mt-3">
                <label for="Name" class="form-label">Name der Klausur:</label>
                <input type="text" class="form-control" id="klausurName" placeholder="Bitte Namen eingeben" name="klausurName">
            </div>
        </div>
           <button type="submit" class="btn btn-primary" name="submitButton">Prüfen</button>
        </form>
    </div>


       @if (isset( $_POST['submitButton'] ) )  <!-- Prüfen ob Button submitted -->
          <div class="container p-5 my-5 border">
               @php
                 $stampDatum = strtotime($klausurDatum);  //Wandelt übergebens Datum in Timestamp um-->
                 $convertDatum = date("l", $stampDatum); //Ermittelt den Wochentag-->
                 $isSunday = false;
                 $isVorlesungszeit = false;
               @endphp

               <h3 style="text-align:center;">Prüfe einen Termin für die Klausur: {{$klausurName}}</h3>

               <div class="alter alert-primary">
               @for($i = 0; sizeof($zeiten)>$i; $i++) <!-- Prüfen ob das Datum in der VL-Freienzeit stattfindent-->

                @if(($zeiten[$i]['start'] <= $klausurDatum) && ($zeiten[$i]['end'] >= $klausurDatum)) <!-- Wenn Klausurdatum innerhalb der VL-Zeit-->
                     <p class="text-center">Der gewählte Termin befindet sich in der Vorlesungszeit</p>
                     {{$isVorlesungszeit = true}}

                @elseif($convertDatum == "Sunday")<!-- Wenn Klausrdatum ein Sonntag-->
                    <p class="text-center">Das gewählt Datum liegt an einem Sonntag</p>
                     {{$isSunday = true}}
                @else
                    @continue
                @endif
              @endfor
            
                @if(($isSunday == false) and ($isVorlesungszeit == false)) <!-- Wenn kein Sonntag und außerhalb der VL-Zeit, dann Termin möglich-->
                    <p class="text-center">Der Termin liegt an keinem Sonntag und ist außerhalb der Vorlesungszeit</p>
                @endif

                @if($radioBtn == 'valueJa') <!-- Wenn geprüft werden soll, ob der Termin am Wochenede liegt-->
                    @if($convertDatum == "Sunday" or $convertDatum == "Saturday")
                        <p class="text-center">Das gewählt Datum liegt an einem Wochenende</p>
                    @else
                        <p class="text-center">Das gewählt Datum liegt an keinem Wochenende</p>
                    @endif
                @endif
              @endif
              </div>
          </div>


  </body>
</html>
