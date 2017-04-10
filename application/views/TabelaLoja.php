<?php if($Lojas):?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-custom">
            <tr class="tb-color">
                <th>Loja</th>
                <th>Endereço</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($lojas):
                foreach ($Lojas as $L):
                    echo "   
                    <tr>
                       <td>{$L['lj_num']}</td>
                       <td>{$L['lj_end']}</td>
                       <td>{$L['lj_bairro']}</td>
                       <td>{$L['lj_cidade']}</td>
                       <td>{$L['lj_uf']}</td>
                    </tr>";
                endforeach;
            endif;
            ?> 
        </tbody>
    </table>
</div>
<?php echo $pagination; 
 else:
    echo "<p class='alert alert-info'>Sem Resultados</p>"; 
 endif;       
?>