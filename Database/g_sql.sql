/*This is suppose to generate the sql query to 
retrieve event and tag info */

/*Things that are needed to call the tags
**hash_number
- tag0
- tag1
- tag2
- tag3
- tag4
**event_id*/

Create View nombre AS
SELECT * from Session
WHERE hash_number = 'hash_number' AND (event_id = 'name1' OR event_id = 'name2') AND (tag0 = 'tag0');

Select * from nombre
WHERE