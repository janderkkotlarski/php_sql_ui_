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
              echo "<th scope='col'>$tag</th>";
              newLine();
            }

            ?>
          </tr>
        </thead>
        <tbody>      
          <?php
          $amount = 1;

          // For each line entry
          foreach ($table as $line) {  
            // Generate source html tabs       
            tabStacks($amount);
            $amount = 4;
            echo "<tr>";
            newLine();
            // For each value entry
            foreach ($line as $value) {
              // Sanitize the entry for displaying
              $sani = htmlspecialchars($value);    
              // Display entry
              // Generate source html tabs 
              tabStacks($amount);
              echo "<td>$sani</td>";
              newLine();
            }
        
						/*
            // Calculate subtotal
            $subtotal = subtotalSummation(0, $line);
            tabStacks($amount);
            // Display subtotal            
            echo "<td>$subtotal</td>";
            newLine();
            $amount = 3;
            // Generate source html tabs 
            tabStacks($amount);
            echo "</tr>";
            newLine();
						*/
          }
          ?>
        </tbody>
      </table>    




<form action="/change" method="POST">
			<?php


			makeFormInput(TAGS[0], 'Sentry', 3);

			makeInputLines($table);

			?>

			<input type="submit" value="Add">
		</form>