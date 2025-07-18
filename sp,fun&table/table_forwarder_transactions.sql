USE [bambi-bmi];
GO

CREATE TABLE  forwarder_transactions (
    ItemNo             INT IDENTITY(1,1) NOT NULL,
    ID_document       VARCHAR(100)  NOT NULL  PRIMARY KEY,
    DOTransacID     char (15)  NULL,
    DONumber         char(30) NULL,
    Tanggal          DATETIME,
    forwaderid       VARCHAR(100) NOT NULL,
    forwadername     VARCHAR(150) NOT NULL,
    pc               VARCHAR(100) NOT NULL,
    notelpon         VARCHAR(100),
    alamat           VARCHAR(255),
    importer         VARCHAR(100),
    consignee        VARCHAR(100),
    supplierid        VARCHAR(100),
    suppliername     VARCHAR(100),
    coderegion       VARCHAR(50),
    jenisbarang      VARCHAR(100),
    hscode           VARCHAR(100),
    jumlah_volume    VARCHAR(100),
    pelabuhan_tujuan  VARCHAR(100),
    eta              DATETIME,
    no_invoice       VARCHAR(100),
    shippingline     VARCHAR(100),
    no_bl_awb        VARCHAR(100),
    container_no     VARCHAR(100),
    vessel_voyage    VARCHAR(100),
    userinput        VARCHAR(100),
    date_input       DATETIME DEFAULT GETDATE(),
    user_update      VARCHAR(100),
    date_update      DATETIME,
    document_files VARCHAR(2000) NULL,
    FlagPosting char(1) DEFAULT 'N',
    UserPosting VARCHAR(100),
    DatePosting datetime,
    FlagPrint char(1) DEFAULT 'N',
    UserPrint VARCHAR(100),
    DatePrint datetime
);

/*ALTER TABLE forwarder_transactions
ADD  FlagPosting char(1) DEFAULT 'N',
UserPosting VARCHAR(100),
DatePosting datetime,
FlagPrint char(1) DEFAULT 'N',
UserPrint VARCHAR(100),
DatePrint datetime*/


--EXEC sp_rename 'forwarder_transactions.pelabuan_tujuan', 'pelabuhan_tujuan', 'COLUMN';

