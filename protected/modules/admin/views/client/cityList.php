<select  id="city_id" name="Client[cityName]" class="form-control ajaxselect2 select2me">  
    <?php
    foreach ($cityListObject as $city) {
//        $citySelected = "";
//        if ($city->id == $cityId)
//            $citySelected = "selected='selected'";
//        if ($i == 0) {
//            $setcityid = $city->id;
//            $i++;
//        }
        //echo $city->id."--------".$cityId;
        ?>			
        <option <?php
        if ($city->id == $cityId) {
            echo 'selected';
        }
        ?> value="<?php echo $city->id ."_".$city->name; ?>"><?php echo $city->name; ?></option> 
            <?php
        }
        ?>		 
</select>

<script>
     $('.ajaxselect2').select2();
    </script>