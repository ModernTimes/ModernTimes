    <table class="table table-condensed" style="border-style: hidden; width: 300px">
        <thead><tr>
            <th></th>
            <th>Current</th>
            <th></th>
            <th>Normal</th>
        </tr></thead>
        <tbody>
        <tr><td width="50%">Resoluteness</td>
            <td style="text-align: center"><?php echo $character->getResolutenessBuffed(); ?></td><td></td><td style="text-align: center">(<?php echo $character->getResolutenessBase(); ?>)</td></tr>
        <tr><td width="50%">Willpower</td>
            <td style="text-align: center"><?php echo $character->getWillpowerBuffed(); ?></td><td></td><td style="text-align: center">(<?php echo $character->getWillpowerBase(); ?>)</td></tr>
        <tr><td width="50%">Cunning</td>
            <td style="text-align: center"><?php echo $character->getCunningBuffed(); ?></td><td></td><td style="text-align: center">(<?php echo $character->getCunningBase(); ?>)</td></tr>
        </tbody>
    </table>
