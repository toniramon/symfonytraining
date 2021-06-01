USE `symfony_training`;

DELETE from category;

-- Insert categories
INSERT INTO category (name, description) VALUES ('Macbook Pro', 'New line of powerfull laptops');
INSERT INTO category (name, description) VALUES ('Macbook Air', 'New line of low-end laptops');
INSERT INTO category (name, description) VALUES ('iMac', 'Line of all in one computers');
INSERT INTO category (name, description) VALUES ('iPhone', 'High-end mobile');

DELETE from product;

-- Insert products
INSERT INTO product (category_id, name, price, currency, featured) VALUES (1, 'Macbook Pro M1 2020 13 inch', 1699.90, 'USD', true);
INSERT INTO product (category_id, name, price, currency, featured) VALUES (1, 'Macbook Pro i7 2019 16 inch', 2699.90, 'EUR', false);
INSERT INTO product (category_id, name, price, currency, featured) VALUES (1, 'Macbook Air M1 2020', 999.90, 'USD', false);
INSERT INTO product (category_id, name, price, currency, featured) VALUES (1, 'iMac M1 2021', 1999.90, 'USD', false);
INSERT INTO product (category_id, name, price, currency, featured) VALUES (1, 'iPhone 12 Pro Max 256GB Space Gray', 1449.90, 'USD', true);