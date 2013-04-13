class CreatePosts < ActiveRecord::Migration
  def change
    create_table :posts do |t|
      t.string :author
      t.string :subject
      t.text :content

      t.timestamps
    end
  end
end
