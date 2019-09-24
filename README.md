# AllFootball-ws

RESTful API utilizzata per ottenere varie informazioni sul calcio.
Sviluppato per l'esame di Piattaforme Digitali per la Gestione del Territorio da Quattrone Cosimo Luca, matricola , per l'anno scolastico 2018-2019.

## Architettura e scelte implementative

### Architettura

L'API è stata scritta ed implementata tramite il linguaggio php. L'intero funzionamento della API è contenuto sul file index.php. Per comunicare col <b>Web-Service</b> basterà inoltrare una richiesta da un qualsiasi client contenente i parametri <i>request</i>, ed in seguito i dati specifici in base alla domanda effettuata. (Es. <i> Id lega, Id squadra, Id partita</i>)
<br><br>
Le richieste possibili sono queste:

  * Ottenere tutti i match di un dato campionato:

  ```sh
  $url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/". $league_id;
  $data = getUrlContent($url);
  ```

  * Ottenere tutte le squadre di un dato campionato:

  ```sh
  $url = "https://api-football-v1.p.rapidapi.com/v2/teams/league/". $league_id;
  $data = getUrlContent($url);
  ```

  * Ottenere tutti i giocatori di una squadra dell'anno 2019-2020 (Stagione attuale):

  ```sh
  $url = "https://api-football-v1.p.rapidapi.com/v2/players/squad/". $team_id ."/2019-2020";
  $data = getUrlContent($url);
  ```

  * Ottenere le formazioni di un incontro:

  ```sh
  $url = "https://api-football-v1.p.rapidapi.com/v2/lineups/". $fixtures_id;
  $data = getUrlContent($url);
  ```

  * Ottenere tutti i match di un campionato di una data giornata:

  ```sh
  $url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/". $league_id ."/Regular_Season_-_". $round;
  $data = getUrlContent($url);
  ```

<br>
In caso di una richiesta non presente fra queste l'applicazione restituirà al client un pacchetto <em>NULL</em> con status_message <em> Richiesta non valida </em>

### Scelte implementative

Per la comunicazione con le eventuali API esterne ho adottato l'utilizzo di CURL, una libreria di php che permette di effettuare richieste HTTP.

Ecco un esempio di utilizzo:
```sh
// inizializzo cURL
$ch = curl_init();

// imposto la URL della risorsa remota da scaricare
curl_setopt($ch, CURLOPT_URL, 'http://www.sito.com/pagina.html');

// imposto che non vengano scaricati gli header
curl_setopt($ch, CURLOPT_HEADER, 0);

// eseguo la chiamata
curl_exec($ch);

// chiudo cURL
curl_close($ch);
```

Per ottenere tutti i giocatori da una squadra ho scelto di impostare l'anno fisso '2019-2020', in modo da ottenere la rosa attuale, altrimenti l'API avrebbe restituito la rosa totale di tutta la squadra, quindi con ripetizioni di giocatori (Uno per ogni anno) e problemi simili:
```sh
$url = "https://api-football-v1.p.rapidapi.com/v2/players/squad/". $team_id ."/2019-2020";
```
<br>
Invece per ottenere tutti i match di una singola giornata ho avuto inizialmente problemi a far passare dal client la stringa 'Regular Season - 9'.
Inizialmente ho utilizzato la funzione php 'urlencode' e 'urldecode', per velocizzare invece la comunicazione tra server e client ho deciso di far rimanere statica la scritta 'Regular_Season_-_ ' e comunicare solamente il numero effettivo, per poi usare la concatenazione php:

```sh
$url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/". $league_id ."/Regular_Season_-_". $round;
```

Ho inoltre scelto di non passare al client l'oggetto JSON passato dall'API esterna, ma di rielaborare, tramite apposite funzioni, le informazioni ottenute e ottimizzarle in modo da rendere più veloce la comunicazione http.

## Extern API Utilizzate

Ho utilizzato le API esterne di www.api-football.com.<br>
Le API di questa piattaforma permettono di ottenere numerose informazioni sui match di calcio e non solo. Per utilizzare il servizio è però obbligatorio sottoscrivere un abbonamento gratuito, che mette a disposizione dell'utente delle chiamate limitate.

### Dati di ritorno

I dati restituiti dalle API di API-FOOTBALL sono tutti in formato [JSON](https://www.json.org/)

### Licenze

Come descritto dai termini di utilizzo, i dati sono accessibili da ogni utente con abbonamento(Gratuito), ci sono però delle restrizioni che vengono elencate nella [pagina dei termini di servizio](https://www.api-football.com/terms).

## Documentazione API

La specifica dell'API è stata progettata seguendo lo standard RESTful. Si può inoltre trovare all'interno della repository, il [file](https://github.com/LucaCosimo-Quattrone/piattaformeDigitali-ws/blob/master/allfootball.yaml) '.yaml' che descrive il funzionamento dele API seguendo lo standard Open API 3.0.0. Per lo sviluppo del file .yaml ho utilizzato l'editor e validator [SwaggerHub](https://app.swaggerhub.com/home)

| Endpoint | Descrizione     |
| :------------- | :------------- |
| /v2/fixtures/league/{LeagueId}      | Metodo GET. Restituisce tutti gli incontri di un determinato campionato  |
| /v2/teams/league/{LeagueId}       | Metodo GET. Restituisce tutte le squadre di un determinato campionato |
| /v2/players/squad/{TeamId}/{SeasonYear}       | Metodo GET. Restituisce tutti i giocatori di un squadra di un preciso anno |
| /v2/lineups/{IdPartita}      | Metodo GET. Restituisce le formazioni di un incontro |
| /v2/fixtures/league/{LeagueId}/{RoundNumber}    | Metodo GET. Restituisce gli incontri di un determinato campionato in base alla giornata scelta |


## Richieste e risposte API

Con [URL] viene inteso l'indirizzo del web service utilizzato ovvero: piattaformedigitali-ws.herokuapp.com

### getAllInfoByMatch

  <b>Richiesta: </b>

    curl -X GET "https://[url]/index.php?request=general&league_id=2"

  <b>Parametri: </b>

    - request: Specifica la richiesta fatta dal client.
    - league_id: L'id della lega scelta.
  
  <b>Codici risposta: </b>

  | Codice | Significato     |
  | :------------- | :------------- |
  | 200 | Risposta ok |
  | 204 | Nessun risultato |
  | 400 | Errore |

  <b> Esempio di risposta: </b>

        [
              {
                  "fixture_id": 65,
                  "league_id": 2,
                  "event_date": "2018-08-10T19:00:00+00:00",
                  "round": "Regular Season - 1",
                  "status": "Match Finished",
                  "homeTeam": {
                      "team_id": 33,
                      "team_name": "Manchester United",
                      "logo": "https://media.api-football.com/teams/33.png"
                  },
                  "awayTeam": {
                      "team_id": 46,
                      "team_name": "Leicester",
                      "logo": "https://media.api-football.com/teams/46.png"
                  },
                  "score": {
                      "halftime": "1-0",
                      "fulltime": "2-1",
                      "extratime": null,
                  }
              },
              {
                  "fixture_id": 66,
                  "league_id": 2,
                  "event_date": "2018-08-11T11:30:00+00:00",
                  "round": "Regular Season - 1",
                  "status": "Match Finished",
                  "homeTeam": {
                      "team_id": 34,
                      "team_name": "Newcastle",
                      "logo": "https://media.api-football.com/teams/34.png"
                  },
                  "awayTeam": {
                      "team_id": 47,
                      "team_name": "Tottenham",
                      "logo": "https://media.api-football.com/teams/47.png"
                  },
                  "score": {
                      "halftime": "1-2",
                      "fulltime": "1-2",
                      "extratime": null,
                  }
              },
              {
                  ...
              }
        ]


### getAllInfoByMatchWithRound

  <b>Richiesta: </b>

    curl -X GET "https://[url]/index.php?request=roundfix&league-id=524&round=3"

  <b>Parametri: </b>
  
    - request: Specifica la richiesta fatta dal client.
    - league_id: L'id della lega scelta.
    - round: Il numero della giornata scelta.

  <b>Codici risposta: </b>

  | Codice | Significato     |
  | :------------- | :------------- |
  | 200 | Risposta ok |
  | 204 | Nessun risultato |
  | 400 | Errore |

  La risposta sarà simile a quella precedente viene solo applicato un filtro sulla giornata attuale, ma lo schema dell'oggetto JSON rimane lo stesso.

### getAllSquadByLeague

  <b>Richiesta: </b>

    curl -X GET "https://[url]/index.php?request=squad&league-id=524"

  <b>Parametri: </b>
  
    - request: Specifica la richiesta fatta dal client.
    - league_id: L'id della lega scelta.

  <b>Codici risposta: </b>

  | Codice | Significato     |
  | :------------- | :------------- |
  | 200 | Risposta ok |
  | 204 | Nessun risultato |
  | 400 | Errore |

  <b> Esempio di risposta: </b>

    [
          {
              "team_id": 33,
              "name": "Manchester United",
          },
          {
              "team_id": 46,
              "name": "Leicester",
          },
          {
              "team_id": 34,
              "name": "Newcastle",
          },
          {
              ...
          }
    ]



### getAllPlayerBySquad

  <b>Richiesta: </b>

    curl -X GET "https://[url]/request=player&team-id=3456"

  <b>Parametri: </b>
  
    - request: Specifica la richiesta fatta dal client.
    - team_id: L'id della lega scelta.

  <b>Codici risposta: </b>

  | Codice | Significato     |
  | :------------- | :------------- |
  | 200 | Risposta ok |
  | 204 | Nessun risultato |
  | 400 | Errore |

  <b> Esempio di risposta: </b>

    [
          {
              "player_id": 272,
              "player_name": "Adrien Rabiot",
              "firstname": "Adrien",
              "lastname": "Rabiot",
              "number": null,
              "position": "Midfielder",
              "age": 24,
              "nationality": "France",
              "height": "188 cm",
              "weight": "71 kg"
          },
          {
              "player_id": 85062,
              "player_name": "Thiago Motta",
              "firstname": "Thiago",
              "lastname": "Motta",
              "number": null,
              "position": "Midfielder",
              "age": 36,
              "nationality": "Italy",
              "height": "187 cm",
              "weight": "83 kg"
          },
          {
              ...
          }
    ]


### getLineupsByFixtures

  <b>Richiesta: </b>

    curl -X GET "https://[url]/index.php?request=lineup&fix_id=724131&home-team=Paris-Saint-Germain&away-team=nice"
    
  <b>Parametri: </b>
  
    - request: Specifica la richiesta fatta dal client.
    - fix_id: L'id del match scelto.
    - home-team: Il nome della squadra di casa.
    - away-team: Il nome della squadra ospite.

  <b>Codici risposta: </b>

  | Codice | Significato     |
  | :------------- | :------------- |
  | 200 | Risposta ok |
  | 204 | Nessun risultato |
  | 400 | Errore |

  <b> Esempio di risposta: </b>

      [
        "Paris Saint Germain": {
                  "formation": "4-2-3-1",
                  "startXI": [
                      {
                          "player": "Alphonse Aréola",
                          "number": 16,
                          "pos": "G"
                      },
                      {
                          "player": "Dani Alves",
                          "number": 13,
                          "pos": "M"
                      },
                      {
                          "player": "Marquinhos",
                          "number": 5,
                          "pos": "D"
                      },
                      {
                          ...
                      }
                  ]
        },
        "Nice": {
                  "formation": "4-3-3",
                  "startXI": [
                      {
                          "player": "Walter Benítez",
                          "number": 40,
                          "pos": "G"
                      },
                      {
                          "player": "Patrick Burner",
                          "number": 15,
                          "pos": "D"
                      },
                      {
                          "player": "Christophe Herelle",
                          "number": 29,
                          "pos": "D"
                      },
                      {
                          ...
                      }
        }
      ]

## Infrastruttura server

Il server è attualmente attivo sulla piattaforma [heroku](https://dashboard.heroku.com). Grazie alla funzionalità di <b>continuos delivering</b> è possibile collegare il progetto creato su heroku alla nostra repository su gitHub, in questo modo ogni volta che verrà effettuato un cambiamento al branch master heroku si occuperà automaticamente di riefettuare la build e quindi integrare in automatico le modifiche sul Web-Server attualmente online.

### Interazione con la piattaforma

Per interagire con la piattaforma è stato realizzato un apposito client, che sfrutti al meglio le API messe a disposizione dal ws.
Il client è realizzato in PHP/Html, l'idea è quello di simulare un sito web calcistico in cui vengono riportate tutte le notizie sul campionato di Premier League 2019/2020. Data la profondità del client è stato deciso di creare una [seconda repository](https://github.com/LucaCosimo-Quattrone/AllFootball-ws) in ci viene spiegata brevemente l'interfaccia e il funzionamento.
