create table sample_table(
    id int not null auto_increment primary key,
    product_name VARCHAR(200) COMMENT '商品名',
    product_price int COMMENT '価格',
    created_at timestamp NOT NULL DEFAULT current_timestamp COMMENT '作成日時',
    updated_at timestamp NOT NULL DEFAULT current_timestamp COMMENT '更新日時'
);

INSERT INTO sample_table(product_name , product_price) VALUES('aaaaa', 1234);