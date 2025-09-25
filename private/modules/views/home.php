<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bonjour – Mon Site</title>
    <meta name="description" content="Une simple page d'accueil qui dit bonjour." />
    <style>
      :root{
        --bg: #f7f7f8;
        --fg: #111113;
        --muted: #6b7280;
        --card: #ffffff;
        --ring: rgba(17,17,19,0.08);
      }
      @media (prefers-color-scheme: dark){
        :root{
          --bg: #0b0c0f;
          --fg: #e5e7eb;
          --muted: #9aa3af;
          --card: #111318;
          --ring: rgba(229,231,235,0.12);
        }
      }
      *{box-sizing:border-box}
      html,body{height:100%}
      body{
        margin:0;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji";
        background: var(--bg);
        color: var(--fg);
        line-height:1.6;
      }
      .wrap{
        min-height:100%;
        display:grid;
        place-items:center;
        padding: clamp(24px, 5vw, 48px);
      }
      .card{
        width:min(780px, 100%);
        background: var(--card);
        border-radius: 18px;
        box-shadow: 0 1px 2px var(--ring), 0 8px 24px var(--ring);
        padding: clamp(20px, 4vw, 40px);
      }
      h1{
        margin:0 0 .25em;
        font-size: clamp(28px, 5vw, 44px);
        letter-spacing:-0.02em;
      }
      p{margin:.5em 0 1.25em; color: var(--muted); font-size: clamp(16px, 2.5vw, 18px)}
      .cta{
        display:inline-block;
        padding:.8em 1.1em;
        border-radius:12px;
        text-decoration:none;
        border:1px solid var(--ring);
        transition: transform .05s ease, box-shadow .2s ease;
        user-select:none;
      }
      .cta:focus-visible{outline:3px solid var(--ring); outline-offset:3px}
      .cta:hover{box-shadow: 0 2px 10px var(--ring)}
      .cta:active{transform:translateY(1px)}
      footer{margin-top: 1rem; font-size: 14px; color: var(--muted)}
    </style>
  </head>
  <body>
    <main class="wrap" role="main">
      <section class="card" aria-label="Présentation">
        <h1>Bonjour 👋</h1>
        <p>Bienvenue sur mon site. Ceci est une page HTML de base — légère, accessible et prête à être publiée.</p>
        <a class="cta" href="#" aria-label="Découvrir plus">En savoir plus</a>
        <footer>
          <p>Vous pouvez modifier ce texte dans votre éditeur pour personnaliser l'accueil.</p>
        </footer>
      </section>
    </main>
  </body>
</html>

