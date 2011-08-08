MySQL benchmark of selecting max/min row per group
==================================================

Benchmark of few solutions mentioned in articles at xaprb.com:

* http://www.xaprb.com/blog/2006/12/07/how-to-select-the-firstleastmax-row-per-group-in-sql/
* http://www.xaprb.com/blog/2007/03/14/how-to-find-the-max-row-per-group-in-sql-without-subqueries/

Data sets
---------

* One small (10 entries)
* One big (15000 entries)

Queries
-------

* One correlated query

```sql
SELECT name, price, fruit_type_id
FROM fruit
WHERE price = (
    SELECT MIN(price)
    FROM fruit AS f
    WHERE f.fruit_type_id = fruit.fruit_type_id
)
```

* One self-join query

```sql
SELECT f.name, f.price, f.fruit_type_id
FROM (
    SELECT fruit_type_id, MIN(price) as minprice
    FROM fruit
    GROUP BY fruit_type_id
) AS x
INNER JOIN fruit AS f
    ON f.fruit_type_id = x.fruit_type_id
    AND f.price = x.minprice
```

Results
-------

Run on computer with MySQL server 5.5.8 and processor AMD Athlon II X3 440.

    === Small dataset ===
    correlatedSubquery: 0.0038859844207764 s
    selfJoin: 0.0026397705078125 s
    correlatedSubquery (price index): 0.0016379356384277 s
    selfJoin (price index): 0.0015709400177002 s

    === Big dataset ===
    correlatedSubquery: 45.861655950546 s
    selfJoin: 0.065365791320801 s
    correlatedSubquery (price index): 46.903476953506 s
    selfJoin (price index): 0.032746076583862 s

Price index means query on fruit table with index on price column.