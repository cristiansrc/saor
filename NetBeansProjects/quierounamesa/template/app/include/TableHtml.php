<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableHtml
 *
 * @author Cristhiampc
 */
class TableHtm {
    //put your code here
    
    public function functionJs() {
        ?>
        <script type="text/javascript">
        // INIT DATATABLES
        $(function () {
                // Init
            var spinner = $( ".spinner" ).spinner();
            var table = $('#<?php echo $this->table?>').dataTable( {
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            } );

            var tableTools = new $.fn.dataTable.TableTools( table, {
                "sSwfPath": "<?php echo _TEMPLATE_SCRIPTS?>/vendors/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "buttons": [
                    "Copiar",
                    "csv",
                    "xls",
                    "pdf",
                    { "type": "print", "buttonText": "Print me!" }
                ]
            } );
            $(".DTTT_container").css("float","right");
        });
        </script>
        <?php
    }

    protected function tableHtml($head, $body) {
        $html = '
            <div class="row mbm">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="' . $this->table . '" class="table table-hover table-striped table-bordered table-advanced tablesorter display">
                        ' . $head . '
                        ' . $body . '
                        </table>
                    </div>
                </div>
            </div>
        ';
        
        return $html;
    }
    
    protected function headTrHtml() {
        $html = '
            <thead>
            <tr>
            %s
            </tr>
            </thead>
        ';
        
        return $html;
    }
    
    protected function bodyHtml() {
        $html = '
            <tbody>
            %s
            </tbody>
        ';
        
        return $html;
    }
    
    protected function thHtml() {
        $html = '
            <th>
            %s
            </th>
        ';
        
        return $html;
    }
    
    protected function trHtml($text = '') {
        $html = '
            <tr ' . $text . '>
            %s
            </tr>
        ';
        
        return $html;
    }
    
    protected function tdHtml($style = '') {
        $html = '
            <td>
            %s
            </td>
        ';
        
        return $html;
    }
    
    
    protected function buttonUpdate($url, $id) {
        $html = '
            <form action="' . $url . '" method="POST">
               <input type="hidden" name="id" value="' . $id . '">
                <button value="" class="btn btn-default btn-xs"><i class="fa fa-edit"></i>&nbsp;Editar</button>
            </form> 
        ';
        
        return $html ;
    }
    
    protected function buttonDelete($id) {
        $html = '
            <a href="javascript:void(0)" class="delete btn btn-default btn-xs"><i class="fa fa-trash-o"></i>&nbsp;Eliminar</a>
        ';
        
        return $html ;
    }
    
    

}
