<?php
$vue_report_filter .= "      <FilterSelectInput v-model=\"form.$field\" name=\"$field\" id=\"$field\" label=\"$field_label\"
        :options=\"[{null: 'All'}, {yes: 'Yes'}, {no: 'No'}]\" />\n";