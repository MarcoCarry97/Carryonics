/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import com.mysql.jdbc.Statement;
import com.oreilly.servlet.MultipartRequest;
import com.oreilly.servlet.multipart.FilePart;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintWriter;
import java.sql.Blob;
import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.naming.Context;
import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.servlet.ServletException;
import static javax.servlet.SessionTrackingMode.URL;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import static org.apache.catalina.startup.ClassLoaderFactory.RepositoryType.URL;

/**
 *
 * @author Marco-PC
 */
public class Insert extends HttpServlet {
        
    private Connection connection;
    private PreparedStatement control;
    private String sql;
    
    @Override
    public void init()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
            sql="select id,name,amount from products where name=?";
            control=connection.prepareStatement(sql);
           connection.setAutoCommit(false);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            //out.println("take");
            /* TODO output your page here. You may use following sample code. */
            String name=request.getParameter("name");
            //out.println("taken");
            control.setString(1,name);
            //out.println("0k");
            ResultSet result=control.executeQuery();
            //out.println(result.toString());
           //out.println(result.first());
            if(result.first())
            {
                int amount=Integer.parseInt(request.getParameter("amount"));
               // out.println(amount);
                int resAmount=result.getInt("amount");
               // out.println(resAmount);
                long id=result.getLong("id");
                String firstSql="update products set amount=? where id=?";
               // out.println(id);
                PreparedStatement first=connection.prepareStatement(firstSql);
                first.setInt(1,amount+resAmount);
                first.setLong(2,id);
                //out.println("done");
                connection.setTransactionIsolation(Connection.TRANSACTION_SERIALIZABLE);
                int res=first.executeUpdate();
                if(res==1)
                    {
                        connection.commit();
                        out.print("this product is already in DB, now there are "+(amount+resAmount)+" units");

                    }
                    else{
                        connection.rollback();
                        out.println("Error!");
                    }
            }
            else
            {
                //out.println("insert");
                String desc=request.getParameter("desc");
                String cat=request.getParameter("cat");
                if(cat.equals("musics")) cat=request.getParameter("format");
                int amount=Integer.parseInt(request.getParameter("amount"));
                String genre=request.getParameter("genre");
                String firstSql="insert into products set name=?, description=?, category=?, amount=?, genre=?,photo=?, release_date=?, price=?";
                //out.println(cat);
                
                PreparedStatement first=connection.prepareStatement(firstSql,Statement.RETURN_GENERATED_KEYS);
                first.setString(1, name);
                first.setString(2, desc);
                first.setString(3, cat);
                first.setInt(4, amount);
                first.setString(5, genre);
                
                //out.println("stream");
                String imgName=request.getParameter("image");
                //String imgPath="D:\\Progetti\\Web\\Managing\\images\\"+File.separator+imgName;
               
                //out.println("ok");
                
               try
               {
                   String imgPath=storeImage(imgName);
                   first.setString(6, imgPath);
                  // out.println("photo-ok");
                    
               }
               catch(FileNotFoundException e)
               {
                   out.println(e.getMessage());
                 // out.println("File not found");
               }
               catch(SQLException e)
               {
                   out.println(e.getMessage());
               }
               // out.println("yeah");
                String date=request.getParameter("release");
                //out.println(date);
                Date release=null;
                try {
                    long millis=new SimpleDateFormat("yyyy-MM-dd").parse(date).getTime();
                    release=new Date(millis);
                } catch (ParseException ex) {
                    Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
                }
                
               // outflo.println(release.toString());
                first.setDate(7, release);
               // out.println(release.toString());
               // out.println(first.toString());
               // out.println("execute");
               float price=Float.parseFloat(request.getParameter("price"));
               first.setFloat(8,price);
                try
                {
                    connection.setTransactionIsolation(Connection.TRANSACTION_SERIALIZABLE);
                   // connection.prepareStatement("Start transaction;").execute();
                    first.executeUpdate();
                }
                catch(Exception e)
                {
                    out.println(e.getMessage());
                }
                
                //out.println("first");
                
                ResultSet set=first.getGeneratedKeys();
                set.next();
                long id=set.getLong(1);
                //out.println(id);
                PreparedStatement second = getStatement(connection,cat,request,id);
                try
                {
                   //out.println(second.toString());
                    int res=second.executeUpdate();
                    if(res==1)
                    {
                        connection.commit();
                        out.println("Data inserted in DB!");
                    }
                    else{
                        connection.rollback();
                        connection.rollback();
                        out.println("Error!");
                    }
                     //connection.prepareStatement("commit;").execute();
                }
                catch(Exception e)
                {
                    out.println(e.getMessage());
                }
               
            }
        } catch (SQLException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            out.close();
        }
    }

    private PreparedStatement getStatement(Connection connection,String cat,HttpServletRequest request, long id) throws SQLException
    {
        String secondSql="insert into "+cat+" ";
        PreparedStatement state=null;
        if(cat.equals("books"))
        {
            secondSql+="(product,author,isbn,pages,comic,publisher) values (?,?,?,?,?,?)";
            state=connection.prepareStatement(secondSql);
            state.setLong(1,id);
            String author=request.getParameter("bookauthor");
            state.setString(2,author);
            String isbn=request.getParameter("isbn");
            state.setString(3,isbn);
            int pages=Integer.parseInt(request.getParameter("pages"));
            state.setInt(4, pages);
            System.out.println(secondSql);
            boolean comic=Boolean.parseBoolean(request.getParameter("comic"));
            state.setBoolean(5, comic);
            String publisher=request.getParameter("bookpublisher");
            state.setString(6,publisher);
            return state;
        }
        else if(cat.equals("films"))
        {
            secondSql+="(product,director,producer) values (?,?,?)";
            state=connection.prepareStatement(secondSql);
            state.setLong(1,id);
            String director=request.getParameter("director");
            state.setString(2,director);
            String producer=request.getParameter("filmproducer");
            state.setString(3,producer);
            return state;
        }
        else if(cat.equals("cds") || cat.equals("vinils"))
         {
            secondSql+="(product,author) values (?,?)";
            state=connection.prepareStatement(secondSql);
            state.setLong(1,id);
            String author=request.getParameter("musicauthor");
            state.setString(2,author);
            return state;
        }
        //else if(cat.equals("vinils")) secondSql+="(product,author) values (?,?)";
        else if(cat.equals("games"))
        {
            secondSql+="(product,developer,publisher,console,pegi) values (?,?,?,?,?)";
            state=connection.prepareStatement(secondSql);
            state.setLong(1,id);
            String developer=request.getParameter("developer");
            state.setString(2,developer);
             String publisher=request.getParameter("gamepublisher");
            state.setString(3,publisher);
             String console=request.getParameter("console");
            state.setString(4,console);
            String pegi=request.getParameter("pegi");
             state.setString(5, pegi);
            return state;
        }
        //state= connection.prepareStatement(secondSql);
        return state;
    }
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

    private String storeImage(String imgName) throws FileNotFoundException, IOException
    {
        String path="D:\\\\Programmi\\\\xampp\\\\htdocs\\\\carryonics\\\\"+imgName;
        File image=new File("\\\\localhost\\condiv\\"+imgName);
        File stored=new File(path);
        FileInputStream input= new FileInputStream(image);
        FileOutputStream output= new FileOutputStream(stored);
        int stream=0;
        do
        {
            stream=input.read();
            output.write(stream);
        }
        while(stream!=-1);
        input.close();
        output.close();
        return imgName;

       //throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

}
