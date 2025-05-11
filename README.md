# Mikrotik Routing Filter Rule Editor

A simple PHP web interface to view and edit Mikrotik routing filter rules directly via the RouterOS API.  
**Only rules with the chain `BGP-Internet` are displayed and editable.**

## Features

- **List Routing Filter Rules:**  
  View all Mikrotik routing filter rules with chain `BGP-Internet`.

- **Edit Rules Inline:**  
  Edit any rule in a user-friendly textarea and update it instantly on your Mikrotik router.

- **Safe & Direct:**  
  No regex or auto-modification — you have full control over the rule text.

## Requirements

- PHP 5.6+ (with cURL enabled)
- [routeros_api.class.php](https://github.com/BenMenking/routeros-api) (included in your project)
- Access to your Mikrotik router with API enabled

## Setup

1. **Clone or Download this Repository**

2. **Configure Router Credentials**

   Edit the following lines in your PHP file:
   ```php
   $host = 'YOUR_ROUTER_IP';
   $user = 'YOUR_USERNAME';
   $pass = 'YOUR_PASSWORD';
   ```

3. **Place `routeros_api.class.php` in the same directory**

   You can get it from [here](https://github.com/BenMenking/routeros-api).

4. **Deploy on a Web Server**

   Place the files on your PHP-enabled web server.

5. **Enable API on Mikrotik**

   On your Mikrotik router, make sure the API service is enabled:
   ```
   /ip service enable api
   ```

## Usage

- Open the web interface in your browser.
- You will see a table of all routing filter rules with chain `BGP-Internet`.
- Click **Edit** next to any rule to open the editor.
- Modify the rule as needed and click **Save** to update it on the router.

## Security Warning

- **Do NOT expose this tool to the public internet!**
- Restrict access to trusted users only.
- Your Mikrotik credentials are stored in plain text in the PHP file.

## Credits

- Uses [routeros_api.class.php](https://github.com/BenMenking/routeros-api) by Ben Menking.

## License

MIT License
