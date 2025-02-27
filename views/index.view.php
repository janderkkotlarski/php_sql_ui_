
<!-- Tab depth matters -->      
      <br>
      <!-- Make a table -->
      <table id="table" style="font-size:32px">      
        <thead>
          <tr>
            <?php 
            // For each tag
            foreach(TAGS as $tag) {
              $lang = EN2NL[$tag];
              if ($tag !== 'name') {
                tabStacks(3);
              }
              // Make a translated header list
              echo "<th scope='col'>$lang</th>";
              newLine();
            }

            ?>
            <th scope="col">Subtotaal</th>
          </tr>
        </thead>
        <tbody>      
          <?php
          $amount = 1;

          // For each line entry
          foreach ($groceries as $grocery) {  
            // Generate source html tabs       
            tabStacks($amount);
            $amount = 4;
            echo "<tr>";
            newLine();
            // For each value entry
            foreach ($grocery as $value) {
              // Sanitize the entry for displaying
              $sani = htmlspecialchars($value);    
              // Display entry
              // Generate source html tabs 
              tabStacks($amount);
              echo "<td>$sani</td>";
              newLine();
            }
        
            // Calculate subtotal
            $subtotal = subtotalSummation(0, $grocery);
            tabStacks($amount);
            // Display subtotal            
            echo "<td>$subtotal</td>";
            newLine();
            $amount = 3;
            // Generate source html tabs 
            tabStacks($amount);
            echo "</tr>";
            newLine();
          }
          ?>

          <tr>
            <!-- Total header -->
            <td>Totaal</td>
            <td colspan="2"></td>
            <!-- Total price -->
            <td id="totalCost"><?="$total_price"?></td>
          </tr>
        </tbody>
      </table>    
