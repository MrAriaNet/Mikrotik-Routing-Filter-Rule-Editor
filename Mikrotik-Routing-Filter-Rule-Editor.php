<?php
require('routeros_api.class.php');

$host = 'YOUR_ROUTER_IP';
$user = 'YOUR_USERNAME';
$pass = 'YOUR_PASSWORD';

$API = new RouterosAPI();

if ($API->connect($host, $user, $pass)) {
    $API->write('/routing/filter/rule/print');
    $rules = $API->read();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $edit_rule = $_POST['edit_rule'];

        $API->write('/routing/filter/rule/set', false);
        $API->write('=.id=' . $edit_id, false);
        $API->write('=rule=' . $edit_rule, true);
        $API->read();

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Routing Filter Rules Editor</title>
        <style>
            body { font-family: Arial, sans-serif; direction: ltr; text-align: left; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #888; padding: 6px 10px; text-align: left; }
            th { background: #eee; }
            tr:nth-child(even) { background: #f9f9f9; }
            button { padding: 6px 12px; }
            .edit-form { background: #f5f5f5; padding: 10px; border: 1px solid #ccc; margin-bottom: 20px; }
        </style>
        <script>
            function showEditForm(id, rule) {
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_rule').value = rule;
                document.getElementById('editForm').style.display = 'block';
                window.scrollTo(0,0);
            }
            function hideEditForm() {
                document.getElementById('editForm').style.display = 'none';
            }
        </script>
    </head>
    <body>
    <h2>Mikrotik Routing Filter Rules Editor</h2>

    <div id="editForm" class="edit-form" style="display:none;">
        <form method="post">
            <input type="hidden" name="edit_id" id="edit_id" value="">
            <label for="edit_rule"><b>Edit Rule:</b></label><br>
            <textarea name="edit_rule" id="edit_rule" rows="3" style="width:100%;font-family:monospace;"></textarea><br><br>
            <button type="submit">Save</button>
            <button type="button" onclick="hideEditForm()">Cancel</button>
        </form>
    </div>

    <table>
        <tr>
            <th>Rule</th>
            <th>Action</th>
        </tr>
        <?php foreach ($rules as $rule): ?>
            <?php if (($rule['chain'] ?? '') === 'BGP-Internet'): ?>
                <tr>
                    <td style="font-family:monospace"><?= htmlspecialchars($rule['rule'] ?? '') ?></td>
                    <td>
                        <button type="button" onclick="showEditForm('<?= htmlspecialchars($rule['.id']) ?>', '<?= htmlspecialchars(addslashes($rule['rule'] ?? '')) ?>')">Edit</button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    </body>
    </html>
    <?php
    $API->disconnect();
} else {
    echo "Could not connect to Mikrotik.";
}
?>
