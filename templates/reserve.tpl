<!-- reserve.tpl -->
<div class="text-center">
  <h3>Bates Motel</h3>
  <h2>Reserve a Room</h2>
</div>
<form method="post" action="reserve.php">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="checkin">Check-in</label>
          <input type="date" name="checkin" id="checkin" class="form-control" value="{$reservation['checkin']}"/>
        </div>
        <div class="form-group">
          <label for="checkout">Check-out</label>
          <input type="date" name="checkout" id="checkout" class="form-control" value="{$reservation['checkout']}"/>
        </div>
        <div class="form-group">
          <label for="guests">Number of Guests</label>
          <select id="guests" name="guests">
            {$reservation['guests']}
          </select>
        </div>
        <div class="form-group">
          <input type="submit" name="find" value="Find Room" />
        </div>
      </div>
      <div class="col-sm-8">
        {foreach $rooms as $room}
          {include file="reserve_room.tpl" room=$room}
        {/foreach}
      </div>
     </div>
    </div>
  </div>
</form>
