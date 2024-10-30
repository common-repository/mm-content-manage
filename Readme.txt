=== mm Content Manage ===
Contributors: mancabelli
Donate link: http://plugin.sipl.it/donate
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: excerpt, private, posts, content
Requires at least: 2.5.0
Tested up to: 3.5.1
Stable tag: 1.2

Gestione del contenuto e del riassunto. Gestione di Posts e Pagine private.
== Description ==

Utilizzabile per la gestione del content di pagine e posts. In homepage puoi scegliere se visualizzare l'intero contenuto o un riassunto. Nella visualizzazione singola della pagina o del post puoi scegliere se visualizzare il contenuto aperto al pubblico o riservarlo ad utenti.

== Installation ==

1. Installazione normale di un plugin wordpress.

== Frequently Asked Questions ==
= Posso limitare l'accesso ad un articolo ad un gruppo di utenti? =
Si. nella pagina di editing dell'articolo che hai scelto nel box Opzioni di Pubblicazione del mio plugin seleziona l'opzione privata e scegli una capabilities dall'elenco a discesa.

= Cosa sono le capabilities? =
Le capabilities sono i permessi che sono assegnati ad ogni gruppo di utenti in wordpress. (administrator, editor, etc. etc).
Per accedere alle capabilities devi cliccare su Utenti > Roles. A questo punto ogni Role ha un numero di capabilities. Se clicchi su un Role
potrai vedere l'elenco delle capabilities che gli sono state assegnate. Potrai creare anche nuove capabilities ma per utilizzare al meglio il mio plugin 
devi ricordarti di assegnare la nuova capability a tutti i Role superiori a quello che hai impostato, altrimenti il post o la pagina che hai reso privata
sara' visibile solo al Role e non a quelli che sono superiori, nemmeno all'admin.

= Se non scelgo nessuna opzione cosa succede? =
Se non selezioni alcuna opzione il plugin pubblicher&agrave; l'intero contenuto sia in home che nelle altre pagine.

== Version History ==

== Changelog ==
= 1.1 =
* il riassunto &egrave; ora visibile anche nella pagina degli archivi.

= 1.2 =
* Area admin per l'eliminazione di tutte le chiavi dal db prima della cancellazione del plugin
* Area admin per la gestione delle opzioni

== Upgrade Notice ==

== Screenshots ==