#!/usr/bin/python3

import requests
import json
import sys
from gi.repository import Gtk, Gdk


def getSite(url):
    headers = {
        'Host': '0w1.xyz',
        'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:42.0) Gecko/20100101 Firefox/42.0',
        'Accept': '*/*',
        'Accept-Language': 'tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3',
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest',
        'Referer': 'http://0w1.xyz/',
        'Connection': 'keep-alive',
        'Pragma': 'no-cache',
        'Cache-Control': 'no-cache',
    }

    "site = input('Site Adresi: ')"

    if not (url.startswith('http://') or url.startswith('https://')):
        return('Site adresi http:// ya da https:// ile başlamalıdır')
        sys.exit(1)

    data = 'url={0}'.format(url)

    r = requests.post('http://0w1.xyz/ajax.php', headers=headers, data=data)

    jsonDecode = json.loads(r.text)

    return jsonDecode['url']
    """print("Short URL:", jsonDecode['url'])
    print("Site URL:", jsonDecode['site_url'])"""


class DoSortUrl:

    def enter_callback(self, widget, entry):
        entry_text = entry.get_text()

    def __init__(self):
        # create a new window
        window = Gtk.Window()
        window.set_size_request(600, 100)
        window.set_resizable(False)
        window.set_title("0w1.xyz URL Shortener")
        window.connect("delete_event", Gtk.main_quit)

        vbox = Gtk.VBox(False, 0)
        window.add(vbox)
        vbox.show()

        site_adres = Gtk.Label("Site Adresi:")
        vbox.pack_start(site_adres, True, True, 0)
        site_adres.show()

        entry = Gtk.Entry()
        entry.connect("activate", self.enter_callback, entry)
        vbox.pack_start(entry, True, True, 0)
        entry.show()

        hbox = Gtk.HBox(False, 0)
        vbox.add(hbox)
        hbox.show()

        button = Gtk.Button(label="Click For Short URL")
        button.connect("clicked", lambda w: entry_ret.set_text(getSite(entry.get_text())))
        vbox.pack_start(button, True, True, 0)
        button.grab_default()
        button.show()

        kisa_url = Gtk.Label("Kısa URL:")
        vbox.pack_start(kisa_url, True, True, 0)
        kisa_url.show()


        entry_ret = Gtk.Entry()
        entry_ret.connect("activate", self.enter_callback, entry)
        entry_ret.set_editable(False)
        vbox.pack_start(entry_ret, True, True, 0)
        entry_ret.show()
        window.show()


def main():
    Gtk.main()

def gtk_style():
    css = b"""
* {
   transition-property: color, background-color, border-color, background-image, padding, border-width;
   transition-duration: 1s;
   font: Cantarell 20px;
}
GtkWindow {
   background: linear-gradient(to left, #2c3e50 , #3498db);
}
.entry {
   color: #6B6B6B;
   background: linear-gradient(to left, #485563 , #29323c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
*:selected {
  color: black;
  background: gray;
}
.button {
   color: black;
   background-color: #bbb;
   padding:10px;
   border-style: solid;
   border-width: 3px 3px 3px 3px;
   border-color: #333;
   padding: 12px 4px;
}
.button:first-child {
   border-radius: 5px 0 0 5px;
}
.button:last-child {
   border-radius: 0 5px 5px 0;
   border-width: 2px;
}
.button:hover {
   padding: 12px 48px;
   background-color: #6B6B6B;
}
.button *:hover {
   color: white;
}
.button:hover:active,
.button:active {
   background-color: #6B6B6B;
}
       """
    style_provider = Gtk.CssProvider()
    style_provider.load_from_data(css)

    Gtk.StyleContext.add_provider_for_screen(
        Gdk.Screen.get_default(),
        style_provider,
        Gtk.STYLE_PROVIDER_PRIORITY_APPLICATION
    )


if __name__ == "__main__":
    gtk_style()
    DoSortUrl()
    main()
