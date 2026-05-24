import fs from 'fs';
import path from 'path';

const oldPath = path.join(process.cwd(), 'public', 'index.php');
const newPath = path.join(process.cwd(), 'public', 'laravel_index.php');

if (fs.existsSync(oldPath)) {
    fs.renameSync(oldPath, newPath);
    console.log('Successfully renamed public/index.php to public/laravel_index.php');
} else {
    console.log('public/index.php not found, skipping rename.');
}
