<table>
    <tr>
    <th>Nom</th> 
    </tr>
    
    <?php foreach ($matieres as $m):  $m = current($m); ?>
    <tr>
        <td><?php echo $m['name']; ?></td>
    </tr>
    
    <?php endforeach; ?>
    
    
</table>