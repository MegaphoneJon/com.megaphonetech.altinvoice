# com.megaphonetech.altinvoice

This is a beta-quality extension that adds an interface to allow selecting alternate recipients of any invoices sent based on their relationship type.
It also currently adds a link to the user's contact dashboard to allow for online invoice payment.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM 5.4+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.megaphonetech.altinvoice@https://github.com/FIXME/com.megaphonetech.altinvoice/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/com.megaphonetech.altinvoice.git
cv en altinvoice
```

## Usage

* Go to **Administer menu » Customize Data and Screens » Relationship Types**.
* Click **Edit** next to the relationship you'd like to use to designate who receives a CC of an invoice.
* Set *CC invoice emails to this relationship* to **Yes** and press **Save**.

You may specify multiple relationships.  The extension will pick up the CC regardless of which side of the relationship a contact is on.

## Future impeovements

Contact me if you're interested in funding the following improvements:
* Enhance invoice setting to specify the direction of the relationship (a-b, b-a, both)
* Allow selection of "replace", "cc", or "bcc" for the mail header.
