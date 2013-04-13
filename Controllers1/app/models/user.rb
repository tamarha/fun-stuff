class User < ActiveRecord::Base
  attr_accessible :email_address, :first_name, :last_name, :password

  validates :first_name, :last_name, :email_address, :password, :presence => true
end
