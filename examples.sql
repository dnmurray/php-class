-- left inner join of room and room_size
-- list all room numbers and the bed description
 select r.rid, rs.room_size
     from room r
     join room_size rs on rs.abbr = r.roomsize;

-- list all existing reservations by room
 select r.rid, rv.*
     from room r
     join reservation rv on rv.rid = r.rid;

-- find all rooms and reservations
select r.rid, rs.room_size, rv.*
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv on rv.rid = r.rid;

-- find all rooms with reservations on a certain date (outer join)
select r.rid, rs.room_size, rv.*
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv
    on rv.rid = r.rid
     and rv.arrival = '2015-05-16'
  where rv.arrival is null
  order by r.rid;

-- reserve a room query (v1)
select rs.room_size, r.rate, r.image, r.sleeps
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv
    on rv.rid = r.rid
     and rv.checkin = '2015-05-16'
  where rv.checkin is null
  group by r.roomsize, r.rate, r.sleeps, r.image
  order by r.rate desc;

-- work query to make sure we 103 is available.
select r.rid, rv.*
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv
    on rv.rid = r.rid
     and rv.checkout > '2015-05-18'
       and rv.checkin < '2015-05-19'
  order by r.rid;

-- reserve a room query, 5/16, 2 nights (v2)
select rs.room_size, r.rate, r.image, r.sleeps, count(*) cnt
  from room r
  join room_size rs on rs.abbr = r.roomsize
  left outer join reservation rv
    on rv.rid = r.rid
     and rv.checkout > '2015-05-18'
       and rv.checkin < '2015-05-19'
  where rv.checkin is null
    and r.sleeps >= 2
  group by r.roomsize, r.rate, r.sleeps, r.image
  order by r.rate desc;
