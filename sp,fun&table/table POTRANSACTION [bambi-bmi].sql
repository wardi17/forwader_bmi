USE [bambi-bmi]
GO

/****** Object:  Table [dbo].[POTRANSACTION]    Script Date: 11/8/2024 9:59:23 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[POTRANSACTION](
	[DOTypeID] [char](5) NULL,
	[DOTransacID] [char](15) NOT NULL,
	[SOTransacID] [char](15) NULL,
	[DONumber] [char](30) NULL,
	[EntryDate] [datetime] NULL,
	[DODate] [datetime] NOT NULL,
	[DueDate] [datetime] NULL,
	[truck] [char](30) NULL,
	[driver] [char](30) NULL,
	[prepareby] [char](30) NULL,
	[logistic] [char](30) NULL,
	[Note] [text] NULL,
	[subtotalafterdisc] [float] NULL,
	[amountcashdisc] [float] NULL,
	[amounttax] [float] NULL,
	[totalamount] [float] NULL,
	[LastUserIDAccess] [char](10) NULL,
	[LastDateAccess] [datetime] NULL,
	[FlagPosting] [char](1) NULL,
	[UserPosting] [char](10) NULL,
	[DatePosting] [datetime] NULL,
	[FlagPostingInv] [char](1) NULL,
	[UserPostingInv] [char](10) NULL,
	[DatePostingInv] [datetime] NULL,
	[Outstanding] [float] NULL,
	[Receipt] [float] NULL,
	[CreditMemo] [float] NULL,
	[TempReceipt] [float] NULL,
	[TempCreditMemo] [float] NULL,
	[DebitNote] [float] NULL,
	[TempDebitNote] [float] NULL,
	[attention] [char](30) NULL,
	[shipattention] [char](30) NULL,
	[custtitle] [char](30) NULL,
	[shipcusttitle] [char](30) NULL,
	[custaddress] [text] NULL,
	[kotamadya02] [char](10) NULL,
	[kecamatan02] [char](10) NULL,
	[kodepos02] [char](6) NULL,
	[shipaddress] [text] NULL,
	[kotamadya03] [char](10) NULL,
	[kecamatan03] [char](10) NULL,
	[kodepos03] [char](6) NULL,
	[city] [char](50) NULL,
	[shipcity] [char](50) NULL,
	[country] [char](30) NULL,
	[shipcountry] [char](30) NULL,
	[custphone] [char](30) NULL,
	[shipcustphone] [char](30) NULL,
	[custhp] [char](30) NULL,
	[shipcusthp] [char](30) NULL,
	[billcustfax] [char](30) NULL,
	[shipcustfax] [char](30) NULL,
	[flagcanceldo] [char](1) NULL,
	[suppaddress] [text] NULL,
	[shipkotamadya] [char](10) NULL,
	[shipkecamatan] [char](10) NULL,
	[shipkodepos] [char](6) NULL,
	[suppid] [char](10) NULL,
	[flagppn] [char](1) NULL,
	[ttltax] [float] NULL,
	[gtotal] [float] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


