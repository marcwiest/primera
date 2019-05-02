
## File Structure

|- app/         # WP and PHP code
|- config/      # Node and PHP config files
|- distributed/ # Distributed files (ZIP)
|- public/      # Publicly available files (font, scripts, images)
|- resources/   # Uncompiled assets used to create views and scripts
--

Use `wp_upload_dir()['basedir'].'/cache'` for view caching.
